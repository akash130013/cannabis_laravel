<?php

namespace App\Modules\Store\Controllers;

use App\Enums\NotificationType;
use App\Events\DriverOrderStatusEvent;
use App\Events\UserOrderEvent;
use App\Helpers\CommonHelper;
use DB;
use Illuminate\Http\Request;
use App\Modules\Store\Models\Order;
use App\Modules\Store\Models\Distributor;
use App\Modules\Store\Models\DistributorOrder;
use App\Http\Controllers\Controller;
use App\Modules\Store\Models\DistributorStore;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * @desc used to show orders
     */
    public function index(Request $request)
    {
        try {
            $storeId = Auth::guard('store')->user()->id;

            $data['list'] = Order::with([
                'customer' => function ($q) {
                    $q->with(['proofs']);
                },
                'drivers'
            ])
                ->when($request->type == 'pending', function ($q) {
                    $q->whereIn('order_status', ['order_placed', 'order_verified']);
                })
                ->when($request->type == 'on-going', function ($q) {
                    $q->whereIn('order_status', ['order_confirmed', 'on_delivery', 'driver_assigned']);
                })
                ->when($request->type == 'completed', function ($q) {
                    $q->whereIn('order_status', ['delivered', 'amount_received']);
                })
                ->when($request->type == 'cancelled', function ($q) {
                    $q->whereIn('order_status', ['order_cancelled']);
                })

                ->when($request->startDate, function ($query, $startDate) {
                    $query->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                })
                ->when($request->endDate, function ($query, $endDate) {
                    $query->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                })
                ->when($request->keyword, function ($q) use ($request) {
                    $q->where('order_uid', 'LIKE', "%$request->keyword%");
                })
                ->where('store_id', $storeId)
                ->orderBy('created_at', 'desc')
                ->paginate(config('constants.PAGINATE'));


            $srNo = CommonHelper::generateSerialNumber($data['list']->currentPage(), $data['list']->perPage());
            return view('Store::order.list', ['data' => $data, 'srNo' => $srNo]);
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    /**
     * @desc show detail page
     */
    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $orderDetail   = Order::with(['customer', 'customer.proofs', 'drivers'])
                ->findOrFail($id);
            $data['order'] = $orderDetail;
            $html          = view('Store::order.side-detail')->with($data)->render();
            return response()->json(['html' => $html]);
        }
    }

    /**
     * @desc update data
     */
    public function update(Request $request, $id)
    {
        try {

            $order                  = Order::find($id);
            $order->order_status    = $request->status;
            $order->save();
            if ($request->status == 'order_confirmed') {
                $message = trans('Store::home.ordered_accepted');
                $pushMessage = sprintf(trans('Store::home.push_order_accepting_message'), $order->order_uid);
            }
            if ($request->status == 'order_cancelled') {
                $message = trans('Store::home.ordered_cancelled');
                $pushMessage = sprintf(trans('Store::home.push_order_rejecting_message'), $order->order_uid);
            }

            event(new UserOrderEvent($order->user_id, config('constants.userType.user'), $order->order_uid, 'Order Update', $pushMessage, NotificationType::Order));
            if ($request->ajax()) {
                $response = ['code' => Response::HTTP_OK, 'message' => $message];
                return response()->json($response);
            }
            return redirect('store/order/list?type=on-going')->with('success', ['message' => $message,'code'=>Response::HTTP_OK]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', ['message' => 'Something went wrong','code'=>$e->getCode()]);
        }
    }

    public function cancelOrder(Request $request, $id)
    {
        try {
            $order                  = Order::find($id);
            $order->cancel_reason   = $request->reason;
            $order->cancel_by       = 'store';
            $order->order_status    = trans('order.order_status_enum.order_cancelled');
            $order->save();

            event(new UserOrderEvent($order->user_id, config('constants.userType.user'), $order->order_uid, 'Order Update', 'OrderId ' . $order->order_uid . ' has been ' . trans('order.' . $request->status), NotificationType::Order));
            if ($request->ajax()) {
                $message = trans('Store::home.ordered_cancelled');
                $response = ['code' => Response::HTTP_OK, 'message' => $message];
                return response()->json($response);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', ['message' => 'Something went wrong', 'code' => $e->getCode()]);
        }
    }

    /**
     * @desc show all the driver list
     */
    public function getDriverList(Request $request, $id)
    {
        try {

            $data['order'] = Order::with(['customer'])
                ->findOrFail($id);

            $preAssignedDriverId = [];
            if (isset($data['order']->distributors->first()->id)) {
                $preAssignedDriverId[] = $data['order']->distributors->first()->id;
            }
            $storeId             = Auth::guard('store')->user()->id;
            $data['driver_list'] = DistributorStore::getAllocatedDriverList($storeId, $request, $preAssignedDriverId);   //get drivers

            return view('Store::order.driver-list', compact('id'))->with($data);
        } catch (\Exception $e) {

            return redirect()->back()->with('success', ['message' => 'Something went wrong', 'code' => $e->getCode()]);
        }
    }

    /**
     * @desc driver allocation
     * @param $request , $id
     */
    public function getDriverAllocation(Request $request, $id)
    {
        $order = DistributorOrder::whereHas('allocatedOrder', function ($q) {
            $q->whereNotIn('order_status', ['delivered', 'order_cancelled', 'amount_refund_init', 'amount_refunded', 'amount_received']);
        })->where('distributor_id', $id)->get($request->length);
        $dataTemp = [];
        $offset     = (int) $request->get("start");
        $snStart = (int) ($offset) + (int) 1;
        foreach ($order as $Data) {
            $temp                           = [];
            $temp['sn']                     = $snStart++;
            $temp['Order_ID']               = $Data->allocatedOrder->order_uid;
            $temp['formatted_address']      = json_decode($Data->allocatedOrder->delivery_address)->formatted_address;
            $temp['status']                 = config("constants.ORDER_STATUS." . $Data->allocatedOrder->order_status . "");
            $temp['delivery_date']          = $Data->schedule_date;
            $temp['extra']                  = "Extra Col.";
            $dataTemp[]                     = $temp;
        }

        $data['driver_id']          = $id;
        $data['order']              = $request->order_id ? $request->order_id : null;
        $data['draw']               = $request->draw ?  $request->draw : '1';
        $data['recordsTotal']       = $order->count();
        $data['recordsFiltered']    = $order->count();
        $data['data'] = $dataTemp;

        // $data['data'] = $order->items();
        // $html                      = view('Store::order.allocation-detail')->with($data)->render();

        return response()->json($data);
    }




    /**
     * @desc assign to driver
     * @param $request ,$id
     */
    public function assignToDriver(Request $request, $id)
    {

        try {
            DB::transaction(function () use ($request, $id) {
                $delivery_time = $request->delivery_time != null ? date('Y-m-d', strtotime($request->delivery_time)) : Carbon::now()->format('Y-m-d');
                $order = Order::find($id);
                $data  = [
                    'distributor_id' => $request->driver_id,
                    'order_id'       => $id,
                    'order_uid'      => $order->order_uid,
                    'schedule_date'  => $delivery_time
                ];
                $driver = Distributor::find($request->driver_id);

                if ($driver->status != config('constants.STATUS.ACTIVE')) {
                    return redirect()->back()->with('success', ['message' => ' Driver blocked by store']);
                }
                if ($driver->admin_status != config('constants.STATUS.ACTIVE')) {
                    return redirect()->back()->with('success', ['message' => 'Driver blocked by admin']);
                }
                DistributorOrder::updateOrCreate(['order_id' => $id], $data);
                Order::where('id', $id)->update(['order_status' => 'driver_assigned']);
                event(new UserOrderEvent($order->user_id, config('constants.userType.user'), $order->order_uid, 'Order Update', trans('order.' . 'driver_assigned') . ' with OrderId ' . $order->order_uid, NotificationType::Order));
                event(new DriverOrderStatusEvent($order->order_uid, "New order assigned", NotificationType::Driver_Order_Assigned, "Order No. " . $order->order_uid . " assigned to you"));
            });
            return redirect('store/order/list?type=on-going')->with('success', ['message' => 'Driver assigned successfully', 'code' => Response::HTTP_OK]);
        } catch (\Exception $e) {
            return redirect()->back()->with('success', ['message' => 'Something went wrong', 'code' => $e->getCode()]);
        }
    }

    /**
     * @desc unassigned driver
     * @param $request
     */
    public function unAssignDriver(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                DistributorOrder::where(['order_id' => $request->id, 'distributor_id' => $request->driverId])->delete();
                Order::where('id', $request->id)->update(['order_status' => 'order_confirmed']);
            });
            return response()->json(['message' => 'Driver un-assigned successfully','code'=>Response::HTTP_OK]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong','code'=>$e->getCode()]);
        }
    }


    /***
     * @desc used for search
     */
    public function searchOrder(Request $request)
    {
        $storeId = Auth::guard('store')->user()->id;


        $result = Order::with([
            'customer' => function ($q) {
                $q->with(['proofs']);
            },
            'drivers'
        ])
            ->when($request->type == 'pending', function ($q) {
                $q->whereIn('order_status', ['order_placed', 'order_verified']);
            })
            ->when($request->type == 'on-going', function ($q) {
                $q->whereIn('order_status', ['order_confirmed', 'on_delivery', 'driver_assigned']);
            })
            ->when($request->type == 'completed', function ($q) {
                $q->whereIn('order_status', ['delivered']);
            })
            ->when($request->type == 'cancelled', function ($q) {
                $q->whereIn('order_status', ['order_cancelled']);
            })
            ->when($request->q, function ($q) use ($request) {

                $q->where('order_uid', 'LIKE', "%$request->q%");
            })
            ->where('store_id', $storeId)
            ->get();


        $data = [];

        if ($result->count()) {

            foreach ($result as $key => $row) {

                $data[]['name'] = $row->order_uid;
            }
        }
        $data = [
            'items' => $data,
        ];

        return response()->json($data);
    }


    /***
     * @desc used for search order driver
     */
    public function searchOrderDriver(Request $request)
    {
        $storeId = Auth::guard('store')->user()->id;


        $result = DistributorStore::with([
            'distributor' => function ($query) use ($request) {
                $query->withCount(['orders']);
            }
        ])
            ->when($request->q, function ($q) use ($request) {
                $q->whereHas('distributor', function ($v) use ($request) {
                    $v->where('name', 'LIKE', "%$request->q%");
                });
            })
            ->whereHas('distributor', function ($query) {

                $query->where('status', '!=', config('constants.STATUS.BLOCKED'));
            })
            ->where('store_id', $storeId)
            ->get();


        $data = [];

        if ($result->count()) {

            foreach ($result as $key => $row) {

                $data[]['name'] = $row->distributor->name;
            }
        }
        $data = [
            'items' => $data,
        ];

        return response()->json($data);
    }
}
