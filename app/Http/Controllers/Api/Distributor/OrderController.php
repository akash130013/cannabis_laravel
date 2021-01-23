<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Enums\NotificationType;
use App\Enums\StoreNotificationType;
use App\Events\DistributorOrderPaymentReceivedEvent;
use App\Events\LPCreditEvent;
use App\Events\NotifyStoreEvent;
use App\Events\StoreEarningEvent;
use App\Events\UserOrderEvent;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Services\DistributorService;
use App\Http\Services\OrderService;
use App\Rules\DistributorOrderStatusRule;
use App\Transformers\OrderTransformer;
use App\Transformers\RatingTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class OrderController
 * @package App\Http\Controllers\Api\Distributor
 * @author Sumit Sharma
 */
class OrderController extends Controller
{
    /**
     * @var distributorService
     */
    protected $distributorService;
    /**
     * @var orderService
     */
    protected $orderService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     * @param DistributorService $distributorService
     */
    public function __construct(OrderService $orderService, DistributorService $distributorService)
    {
        $this->orderService       = $orderService;
        $this->distributorService = $distributorService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'order_status' => ['sometimes', Rule::in(['completed', 'upcoming'])],
            ], [
                'order_status.in' => 'order_status can be completed or upcoming'
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }


            $param = [
                'distributor_id'               => $request->user()->id,
                'order_delivery_schedule_date' => $request->order_delivery_schedule_date,
                'pagesize'                     => $request->pagesize ?? config('constants.PAGINATE'),
                'status'                       => 'active',
                'api'                          => true,

            ];
            if ($request->has('order_status')) {
                if ($request->order_status == "completed") {
                    $orderStatus = ["amount_received"];
                } elseif ($request->order_status == "upcoming") {
                    $orderStatus = ["driver_assigned", "on_delivery", "delivered"];
                }
                $param['in_order_status'] = $orderStatus;
            }
            $orders         = $this->orderService->getOrders($param);
            $orders['data'] = OrderTransformer::TransformCollectionDeliveryOrders($orders);
            unset($param['api']);
            unset($param['pagesize']);
            $orders['order_count'] = $this->orderService->getOrders($param)->count();
            return response()->jsend($data = $orders, $presenter = null, $status = "success", $message = "my orders", $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * order detail.
     * @param string $orderUid
     * @return \Illuminate\Http\Response
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
            $order = OrderTransformer::TransformObjectDeliveryOrder($order);
            return response()->jsend($data = $order, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }
        //
    }

    /**
     * distributor reviews
     * @param Request $request
     * @return mixed
     */
    public function myReviews(Request $request)
    {
        try {
            $param                   = [
                'rated_id'    => $request->user()->id,
                'type'        => config('constants.ratingType.driver'),
                'pagesize'    => $request->pagesize ?? config('constants.PAGINATE'),
                'api'         => true,
                'review_only' => true,
            ];
            $reviews                 = $this->orderService->getRating($param);
            $reviews['reviewStatic'] = $this->orderService->ratingGroupData($param);
            $reviews['rating']       = CommonHelper::fetchAvgRating($request->user()->id, config('constants.ratingType.driver'));
            $reviews['ratingCount']  = CommonHelper::ratingReviewCount($request->user()->id, config('constants.ratingType.driver'));
            $reviews['reviewCount']  = CommonHelper::ratingReviewCount($request->user()->id, config('constants.ratingType.driver'), 'review');
            $reviews['data']         = RatingTransformer::TransformReviewCollection($reviews);
            return response()->jsend($data = $reviews, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }
    }

    /**
     * change order status during delivery
     * @param Request $request
     * @return mixed
     */
    public function changeOrderStatus(Request $request)
    {
        try {
            $request->request->add(['distributor_id' => $request->user()->id]);
            $validator = \Validator::make($request->all(), [
                'order_uid'    => 'required',
                'order_status' => ['required', new DistributorOrderStatusRule($request->order_uid, $request->user()->id)],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $orderStatus['order_status'] = $request->order_status;
            if ($request->order_status == 'delivered') {
                info('Order delivered');
                $orderStatus['delivered_at'] = now('UTC');
            }
                info($orderStatus);
            $status = $this->orderService->updateOrder($request->order_uid, $orderStatus);
            if (!$status) {
                return response()->jsend_error(new \Exception("order could not be updated, try again"), $message = null);
            }
            $order = $this->orderService->getOrders(['order_uid' => $request->order_uid])->first();
            switch ($request->order_status) {
                case 'delivered':
                    event(new UserOrderEvent($order->user_id, config('constants.userType.user'), $order->order_uid, 'Order Update', 'OrderId ' . $order->order_uid . ' has been ' . trans('order.' . $order->status), NotificationType::Order));
                    event(new LPCreditEvent($order->user_id, 'purchase', 'Order_uid:' . $request->order_uid));   
                    break;
                case 'on_delivery':
                    event(new UserOrderEvent($order->user_id, config('constants.userType.user'), $order->order_uid, 'Order Update', 'OrderId ' . $order->order_uid . ' has been ' . trans('order.' . $order->status), NotificationType::Order));
                    $driverStatus = "busy";
                    event(new NotifyStoreEvent($order->store_id, $request->order_uid, StoreNotificationType::OrderStatus, "Order Delivered " . $request->order_uid));

                    break;
                case "amount_received":
                    $driverStatus = "online";
//                    event(new DistributorOrderPaymentReceivedEvent($request->order_uid));
                        event(new StoreEarningEvent($request->order_uid));
                    break;
            }
            if (isset($driverStatus)) {
                $this->distributorService->updateDistributorStatus($driverStatus);
            }


            $order = OrderTransformer::TransformObjectDeliveryOrder($status);
            return response()->jsend($data = $order, $presenter = null, $status = "success", $message = "Order status updated", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

}
