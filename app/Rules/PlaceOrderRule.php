<?php

namespace App\Rules;

use App\AdminDeliveryAddress;
use App\Models\Cart;
use App\Models\LoyaltyPointTransaction;
use App\Models\Order;
use App\Models\PromoCode;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Store\Models\StoreDeliveryAddress;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreProductStockUnit;
use App\Store;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use DB;

class PlaceOrderRule implements Rule
{
    protected $orderUid, $message;


    /**
     * Create a new rule instance.
     * @param $orderUid
     * @return void
     */
    public function __construct($orderUid)
    {
        $this->orderUid = $orderUid;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $order          = Order::where('order_uid', $this->orderUid)->first();
        // dd(DB::getQueryLog());
        
        //check delivery location is blocked or not 
        $address        = AdminDeliveryAddress::where('zipcode',$order->delivery_address['zipcode'])->first();
        $storeAddress   = StoreDeliveryAddress::where('store_id',$order->store_id)->where('zip_code',$order->delivery_address['zipcode'])->first();
        //check category status
        $cartOrderJson  = Cart::where('order_uid', $order->order_uid)->pluck('order_json');

        foreach ($cartOrderJson as $key => $var) 
        {
           
            $product =  CategoryProduct::find($var['product_id']);
            $product->load('getCategory');
            if($product->status != config('constants.STATUS.ACTIVE') ||  $product->getCategory->status != config('constants.STATUS.ACTIVE'))
            {
                $this->message = sprintf(config('constants.OrderRuleMSG.CATEGORY_BLOCKED'),$product->product_name);
                return false;
            }
        }
        if($address->status != config('constants.STATUS.ACTIVE') || $storeAddress->status != config('constants.STATUS.ACTIVE'))
         { 
            $this->message = config('constants.OrderRuleMSG.DELIVERY_LOCATION_BLOCKED');
            return false;
         }

        // get cart checks
        $carts = Cart::where('order_uid', $this->orderUid)->get();
        $store = Store::where('id',$order->store_id)->where(['status'=>'active','admin_action'=>'approve'])->exists();
        if(!$store)
        {
            $this->message = config('constants.OrderRuleMSG.STORE_BLOCKED');
            return false;
        }
        if($order->promo_code)
        {
            $coupon = PromoCode::where(['coupon_code'=> $order->promo_code,'offer_status'=>'active'])->exists();
            if(!$coupon)
            {
                $this->message = config('constants.OrderRuleMSG.COUPON_BLOCKED');
                return false;
            }
        }
        foreach ($carts as $data) {
            $storeProductStockUnit = StoreProductStockUnit::with('storeProductStock')
                ->whereHas('storeProductStock', function ($query) use ($data) {
                    $query->where(['store_id' => $data->store_id, 'product_id' => $data->product_id])
                        ->where('available_stock', '>', 0);
                })
                ->where('quant_unit', $data->size)->where('unit', $data->size_unit)
                ->where('total_stock', '>=', $data->quantity)
                ->first();
            if (!$storeProductStockUnit) 
            {
                $this->message = config('constants.OrderRuleMSG.PRODUCT_UNAVAILABLE');
                return false;
                break;
            }
            if ($storeProductStockUnit->price > $data->selling_price) 
            {
                $this->message = config('constants.OrderRuleMSG.PRICE_INCREASED');
                return false;
                break;
            }

        }


        // check promo code
        if (!is_null($order->promo_code)) {
            $promoCode = PromoCode::where(['coupon_code' => $order->promo_code, 'offer_status' => 'active'])
                ->where(function ($q) {
                    $q->where('start_time', '<=', Carbon::now());
                    $q->where('end_time', '>=', Carbon::now());
                })
                ->where('coupon_remained', '>', 0)
//                                 other queries will be added
                ->first();
            if (!$promoCode) {
                $this->message = config('constants.OrderRuleMSG.INVALID_PROMO_CODE');
                return false;
            }

        }

        // verify loyalty points
        if (isset($order->discounts['loyaltyPoint'])){
            $loyalPoint = LoyaltyPointTransaction::where('user_id', $value)->latest()->first();
            
            if (!$loyalPoint || round($loyalPoint->net_amount,2) < round($order->loyalty_point_used,2)) {
                $this->message = config('constants.OrderRuleMSG.LESS_LOYALTY_POINTS');
                return false;
            }
            
        }

        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
