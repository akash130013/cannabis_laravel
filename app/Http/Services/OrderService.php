<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Cart;
use App\Models\DistributorLocation;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * @var Order
     */
    protected $order;
    /**
     * @var Rating
     */
    protected $rating;

    /**
     * OrderService constructor.
     * @param Order $order
     * @param Rating $rating
     */
    public function __construct(Order $order, Rating $rating)
    {
        $this->order  = $order;
        $this->rating = $rating;
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function getOrders(array $param)
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $orders = $this->order->with(['stores', 'user', 'distributors'])->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })->when(isset($param['order_uid']), function ($q) use ($param) {
                $q->where('order_uid', $param['order_uid']);
            })
            ->when(isset($param['in_order_status']), function ($q) use ($param) {
                $q->whereIn('order_status', $param['in_order_status']);
            })
            ->when(isset($param['user_id']), function ($q) use ($param) {
                return $q->where('user_id', $param['user_id']);
            })->when(isset($param['order_status']), function ($q) use ($param) {
                return $q->where('order_status', $param['order_status']);
            })->when(isset($param['distributor_id']), function ($q) use ($param) {
                $q->whereHas('distributors', function ($query) use ($param) {
                    $query->where('distributors.id', $param['distributor_id']);
                });
            })->when(isset($param['order_delivery_schedule_date']), function ($q) use ($param) {
                return $q->whereHas('distributors', function ($query) use ($param) {
                    return $query->where('distributor_order.schedule_date', $param['order_delivery_schedule_date']);
                });
            });
        if (isset($param['sortBy']) && isset($param['sortOrder'])) {
            $orders = $orders->orderBy($param['sortBy'], $param['sortOrder']);
        } else {
            $orders = $orders->latest();
        }

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $orders = CommonHelper::restPagination($orders->paginate($param['pagesize']));
            } else {
                $orders = $orders->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $orders = $orders->get();
        }
        return $orders;
    }

    /**
     * @param $orderUid
     * @param array $param
     * @return mixed
     */
    public function updateOrder($orderUid, array $param)
    {
        $status = Order::where('order_uid', $orderUid)->update($param);
        if ($status) {
            $order = Order::where('order_uid', $orderUid)->first();
            $order->load('getOrderedProducts');
            CommonHelper::updateQuantityOnCancelledOrder($order->store_id,$order->getOrderedProducts);
            return  $order;
        }
        return false;
    }

    /**
     * @param array $data
     * @param $bulk (optional)
     * @return mixed
     */
    public function saveRatingData(array $data, $bulk = false)
    {
        if ($bulk) {
            foreach ($data as $key => $value){
                $this->rating->create($value);
            }
            return true;
        }
        return $this->rating->create($data);
    }

    /**
     * get rating data
     * @param array $param
     * @return mixed
     */
    public function getRating($param = [])
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $ratings = $this->rating->with('user')->select($selectColumn)
            ->when(isset($param['rated_id']) && isset($param['type']), function ($q) use ($param) {
                return $q->where(['rated_id' => $param['rated_id'], 'type' => $param['type']]);
            })->when((isset($param['review_only']) && $param['review_only'] == true), function ($q){
                    return $q->whereNotNull('review');
            });
        if (isset($param['sortBy']) && isset($param['sortOrder'])) {
            $ratings = $ratings->orderBy($param['sortBy'], $param['sortOrder']);
        } else {
            $ratings = $ratings->latest();
        }
        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $ratings = CommonHelper::restPagination($ratings->paginate($param['pagesize']));
            } else {
                $ratings = $ratings->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $ratings = $ratings->get();
        }
        return $ratings;
    }

    /**
     * @param $param
     * @return mixed
     */
    public function ratingGroupData($param)
    {
        $ratings = $this->rating->select('rate', DB::raw('count(*) as total'))
            ->when(isset($param['rated_id']) && isset($param['type']), function ($q) use ($param) {
                return $q->where(['rated_id' => $param['rated_id'], 'type' => $param['type']]);
            })
            ->groupBy('rate');
        $ratings = $ratings->get();
        return $ratings;
    }

    public function reAddCartfromOrder($orderUid)
    {
        $cartService = new CartService;
        $order       = $this->getOrders(['order_uid' => $orderUid])->first();
        $storeId     = $order->store_id;
        $cartData    = [];
        foreach ($order->order_data['cartListing'] as $item) {
            $data                  = [];
            $data['cart_uid']      = Str::uuid();
            $data['product_id']    = $item['product_id'];
            $data['user_id']       = request()->user()->id;
            $data['store_id']      = $item['store_id'];
            $data['quantity']      = 1; // $item['quantity'];
            $data['size']          = $item['size'];
            $data['size_unit']     = $item['size_unit'];
            $data['selling_price'] = $cartService->fetchSellingPrice($item['product_id'], $item['store_id'], $item['size'], $item['size_unit'], $item['quantity']);
            $data['order_json']    = json_encode($data);
            $data['created_at']    = now()->toDateTimeString();
            $data['updated_at']    = now()->toDateTimeString();
            array_push($cartData, $data);
        }
        return Cart::insert($cartData);

    }

    public function showDistributorLastLocationByOrderUid($orderUid)
    {
        $order = Order::where('order_uid', $orderUid)->first();
        if ($order){
            return DistributorLocation::where('distributor_id', $order->distributors->first()->id)->latest()->first();
        }
        return false;
    }
}
