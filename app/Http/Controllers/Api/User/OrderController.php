<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\NotificationType;
use App\Enums\StoreNotificationType;
use App\Events\DriverOrderStatusEvent;
use App\Events\LPCreditEvent;
use App\Events\LPDebitEvent;
use App\Events\NotifyStoreEvent;
use App\Events\PostPlaceOrderEvent;
use App\Helpers\CommonHelper;
use App\Http\Services\CartService;
use App\Http\Services\DeliveryService;
use App\Http\Services\OrderService;
use App\Models\Order;
use App\Rules\CancelOrderRule;
use App\Rules\PlaceOrderRule;
use App\Rules\ReorderRule;
use App\Rules\TrackOrdeRule;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

/**
 * Class OrderController
 * @package App\Http\Controllers\Api\User
 * @author Sumit Sharma
 */
class OrderController extends Controller
{
    /**
     * @var CartService
     */
    protected $cartService;
    /**
     * @var deliveryService
     */
    protected $deliveryService;
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * DeliveryController constructor.
     * @param CartService $cartService
     * @param DeliveryService $deliveryService
     */
    public function __construct(CartService $cartService, DeliveryService $deliveryService, OrderService $orderService)
    {
        $this->cartService     = $cartService;
        $this->deliveryService = $deliveryService;
        $this->orderService    = $orderService;

    }


    /**
     * user place order
     * @param Request $request
     * @return mixed
     */
    public function placeOrder(Request $request)
    {
        
        try {
            $request->request->add(['user_id' => $request->user()->id]);
            $validator = \Validator::make($request->all(), [
                'order_uid' => ['required', Rule::exists('carts')->where(function ($query) {
                    $query->where(['order_uid' => \request()->order_uid, 'user_id' => request()->user()->id]);
                }), Rule::exists('orders')->where(function ($query) {
                    $query->where('order_uid', \request()->order_uid)->where('order_status', '!=', 'order_placed');
                }),],
                'user_id'   => ['required', new PlaceOrderRule($request->order_uid),]
            ], [
                'order_uid.exists' => 'Invalid Order data or  already placed ',
            ]);

            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // place-order
            $placeOrder = $this->cartService->updateOrder($request->order_uid, ['order_status' => 'order_placed', 'created_at' => now()]);
            if ($placeOrder) {
                $order = $this->orderService->getOrders(['order_uid' => $request->order_uid])->first();

                // post place-order events
                event(new PostPlaceOrderEvent($request->order_uid, $request->user_id));
                event(new NotifyStoreEvent($order->store_id, $request->order_uid, StoreNotificationType::Order, StoreNotificationType::NewOrder, StoreNotificationType::NewOrder . ' orderUID: ' . $request->order_uid));
                if (Arr::has($order->discounts, 'loyaltyPoint')) {
                    event(new LPDebitEvent($order->user_id, 'discounted', 'Order_uid:' . $request->order_uid, $request->order_uid));
                }

                return response()->jsend($data = $order, $presenter = null, $status = "success", $message = "Order Placed", $code = config('constants.SuccessCode'));

            }
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'type' => ['sometimes', Rule::in(['completed', 'pending', 'ongoing', ''])],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $param = [
                'user_id'  => $request->user()->id,
                'pagesize' => $request->pagesize ?? config('constants.PAGINATE'),
                'status'   => 'active',
                'api'      => true,

            ];

            if ($request->has('type') && !empty($request->type)) {
                switch ($request->type) {
                    case "pending":
                        $param['in_order_status'] = ['order_placed', 'order_verified', 'order_confirmed'];
                        break;
                    case "ongoing":
                        $param['in_order_status'] = ['driver_assigned', 'on_delivery'];
                        break;
                    case "completed":
                        $param['in_order_status'] = ['delivered', 'amount_received'];
                        break;
                    case "cancelled":
                        $param['in_order_status'] = ['order_cancelled'];
                        break;
                }
            } else {
                $param['in_order_status'] = ['order_placed', 'order_verified', 'order_confirmed', 'driver_assigned', 'on_delivery', 'delivered', 'amount_received', 'order_cancelled'];
            }
            $orders         = $this->orderService->getOrders($param);
             
            $orders['data'] = OrderTransformer::TransformCollection($orders);

            return response()->jsend($data = $orders, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * order detail
     * @param $orderUid
     * @return mixed
     */
    public function show($orderUid)
    {
        try {
            $param     = [
                'order_uid' => $orderUid,
            ];
            $validator = \Validator::make($param, [
                'order_uid' => ['required', 'exists:orders,order_uid'],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $order = $this->orderService->getOrders($param)->first();
            $order = OrderTransformer::TransformObject($order);
            return response()->jsend($data = $order, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * cancel order from user.
     * @param Request $request
     * @return mixed
     */
    public function cancelOrder(Request $request)
    {
        try {
            $param     = ['order_uid' => $request->order_uid, 'user_id' => $request->user()->id];
            $validator = \Validator::make($param, [
                'user_id'   => 'required',
                'order_uid' => ['required', new CancelOrderRule($param['order_uid'], $param['user_id'])],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $status = $this->orderService->updateOrder($param['order_uid'], ['order_status' => trans('order.order_status_enum.order_cancelled')]);
            if (!$status)
                return response()->jsend_error(new \Exception("Order could not cancelled, please try again"), $message = null);

            $order = $this->orderService->getOrders($param)->first();
            $order = OrderTransformer::TransformObject($order);
            if ($order->order_status == trans('order.order_status_enum.order_cancelled')) {
                event(new DriverOrderStatusEvent($request->order_uid, "Order Cancel " . $request->order_uid, NotificationType::Driver_Order_cancelled, "Order UID:".$request->order_uid." has been cancelled"));

            }
            if (Arr::has($order->discounts, 'loyaltyPoint')) {
                event(new LPCreditEvent($request->user()->id, 'refunded', 'Order_uid:' . $request->order_uid, $request->order_uid));
            }

            event(new NotifyStoreEvent($order->store_id, $request->order_uid, StoreNotificationType::OrderStatus, "Order Cancelled " . $request->order_uid));
            return response()->jsend($data = $order, $presenter = null, $status = "success", $message = "order has been cancelled", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * reorder from previous order.
     * @param Request $request
     * @return mixed
     */
    public function reOrder(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_uid' => ['required', new ReorderRule],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            // clear cart
            $this->cartService->clearCart(['user_id' => $request->user()->id]);

            $reOrder = $this->orderService->reAddCartfromOrder($request->order_uid);
            if (!$reOrder)
                return response()->jsend_error(new \Exception("re-order can not be executed"), $message = null);

            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Re-Order : Product is successfully added in cart", $code = config('constants.SuccessCode'));


        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    public function trackOrder(Request $request, $orderUid)
    {
        try {
            $param = ['order_uid' => $orderUid];
            $validator = \Validator::make($param, [
                'order_uid' => ['required', new TrackOrdeRule],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $driverLocation = $this->orderService->showDistributorLastLocationByOrderUid($orderUid);
            if (!$driverLocation){
                return response()->jsend_error(new \Exception("driver has not updated location"), $message = null);
            }
            return response()->jsend($data = $driverLocation, $presenter = null, $status = "success", $message = "driver last location ", $code = config('constants.SuccessCode'));



        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }
}
