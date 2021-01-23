<?php


namespace App\Http\Services;


use App\Enums\ConfigLabelType;
use App\Models\Cart;
use App\Models\LoyaltyPointTransaction;
use App\Models\Order;
use App\Models\Popularity;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\SiteConfig;
use App\Models\UserPromoCode;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreProductStockUnit;
use App\Transformers\CartTransformer;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CartService
{

    /**
     * @param $productId
     * @param $storeId
     * @param $quantityUnit
     * @param $quantity (optional)
     * @return bool
     */
    public function fetchSellingPrice($productId, $storeId, $size, $size_unit, $quantity = null)
    {
        $storeProductStock = StoreProductStock::with(['currentstock' => function ($query) use ($size, $size_unit) {
            $query->where('quant_unit', $size)->where('unit', $size_unit);
        }])->where(['product_id' => $productId, 'store_id' => $storeId])->first();
        if ($storeProductStock) {
            // $stock = $storeProductStock->currentstock->filter(function ($item) use ($size, $size_unit) {
            //     return (($item->quant_unit == $size) && ($item->unit == $size_unit));
            // });
            $stock = $storeProductStock->currentstock->first();
            if ($stock->price) {
                if (isset($quantity)) {
                    return $quantity * $stock->price;
                }
                return $stock->price;
            }
        }

        return false;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addCart($data)
    {
        // check if cart has already that product_id and store_id, if no add this, otherwise make increment
        $cart = Cart::where([
            'product_id' => $data['product_id'],
            'store_id'   => $data['store_id'],
            'size'       => $data['size'],
            'size_unit'  => $data['size_unit'],
            'user_id'    => $data['user_id'],
        ])->first();
        if (!$cart) {
            $cartData               = [
                'cart_uid'      => Str::uuid(),
                'user_id'       => $data['user_id'],
                'product_id'    => $data['product_id'],
                'store_id'      => $data['store_id'],
                'size'          => $data['size'],
                'size_unit'     => $data['size_unit'],
                'quantity'      => 1,
                'selling_price' => $data['selling_price'],
            ];
            $cartData['order_json'] = $cartData;
            return Cart::create($cartData);
        }

        $increment = $this->incrementCartProduct($cart->id);
        if ($increment) {
            return $cart->refresh();
        }

    }

    /**
     * @param $cartUid
     * @param $userId
     * @return mixed
     */
    public function removeCart($cartUid, $userId)
    {
        return Cart::where(['cart_uid' => $cartUid, 'user_id' => $userId])->delete();
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function showCart(array $param)
    {
        
        return Cart::where($param)->get();
    }

    /**
     * @param $cartId
     */
    protected function incrementCartProduct($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart->quantity < config('constants.CART.MAX_SINGLE_ITEM_QUANTITY')) {
            $cart->increment('quantity');
            $cart->refresh();
            $cart->update(['order_json->quantity' => $cart->quantity]);
        }
    }

    /**
     * @param $cartId
     */
    protected function decrementCartProduct($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart->quantity == 1) {
            $cart->delete();
        }
        $cart->decrement('quantity');
        $cart->refresh();
        $cart->update(['order_json->quantity' => $cart->quantity]);

    }

    /**
     * @param $cartUid
     * @param $quantity
     * @return mixed
     */
    public function updateQuantity($cartUid, $quantity)
    {
        return Cart::where(['cart_uid' => $cartUid])->update(['quantity' => $quantity]);
    }

    /**
     * @param $cartUid
     * @param $quantity
     * @param $size
     * @param $size_unit
     * @return mixed
     */
    public function updateQuantitySize($cartUid, $quantity, $size, $size_unit)
    {
        return Cart::where(['cart_uid' => $cartUid])->update(['quantity' => $quantity, 'size' => $size, 'size_unit' => $size_unit]);
    }

    /**
     *
     * @param array $param
     * @return mixed
     */
    public function createOrder(array $param)
    {
        $orderUid = uniqid('K');
        if (Cart::where('user_id', $param['user_id'])->count() == 0) {
            return false;
        }
        $cart = Cart::where('user_id', $param['user_id'])->whereNotNull('order_uid')->first();
        if ($cart) {
            $orderUid = $cart->order_uid;
        } else {
            $cart = Cart::where('user_id', $param['user_id'])->first();
        }
        $storeId = $cart->store_id;
        $this->updateCartPrice($param);
        Cart::where($param)->update(['order_uid' => $orderUid]);
        Order::updateOrcreate(['order_uid' => $orderUid, 'user_id' => $param['user_id']], ['store_id' => $storeId]);
        return $orderUid;
    }

    public function updateCartPrice(array $param)
    {
        $cart = Cart::where($param)->get();
        foreach ($cart as $key => $value) {
            $itemPrice = $this->fetchSellingPrice($value->product_id, $value->store_id, $value->size, $value->size_unit, $value->quantity);

            $ct_temp                = Cart::find($value->id);
            $ct_temp->selling_price = $itemPrice;
            $ct_temp->save();
            $ct_temp->update(['order_json->selling_price' => $itemPrice]);
        }

    }

    /**
     * @param $orderUid
     * @param array $param
     * @return mixed
     */
    public function updateOrder($orderUid, array $param)
    {
        return Order::where('order_uid', $orderUid)->update($param);
    }

    /**
     * @param $orderUid
     * @param $userId
     * @param $code
     * @return bool
     */
    public function applyPromoCode($orderUid, $userId, $code)
    {
        // check validity
        $promoCode = PromoCode::where(['coupon_code' => $code, 'offer_status' => 'active'])
            ->where(function ($q) {
                $q->where('start_time', '<=', Carbon::now());
                $q->where('end_time', '>=', Carbon::now());
            })
            ->where('coupon_remained', '>', 0)
            //                                 other queries will be added
            ->first();
        if (!$promoCode) {
            return false;
        }

        $promoCodeUsed = Order::where(['user_id' => $userId, 'promo_code' => $code])->where('order_status', '<>', 'init')->count();
        if ($promoCodeUsed > $promoCode->max_redemption_per_user) {
            return false;
        }
        $order        = Order::where('order_uid', $orderUid)->first();
        $cart         = Cart::where('order_uid', $orderUid)->get();
        $cart         = CartTransformer::TransformCollection($cart);
        $cartSubtotal = $cart->sum('item_subtotal');
        UserPromoCode::updateOrCreate(['user_id' => $userId, 'order_uid' => $orderUid], ['promo_code' => $code]);
        if ($order) {
            $order->promo_code = $code;
            $discount          = $this->calculateDiscount($cartSubtotal, $promoCode->promotional_type, $promoCode->amount, $promoCode->max_cap);

            $order->fill(['discounts->promo_discount' => $discount]);
            if ($order->save()) {
                $order->net_amount = $cartSubtotal - array_sum(array_values($order->discounts));
                $order->save();
                return $discount;

            }
        }

        return false;
    }

    /**
     * @param $cartSubtotal
     * @param $promotionalType
     * @param $amount
     * @param $max_cap
     * @return float|int
     */
    protected function calculateDiscount($cartSubtotal, $promotionalType, $amount, $max_cap)
    {
        $discount_amount = 0;
        switch ($promotionalType) {
            case "fixed":
                $discount_amount = $amount;
                if ($discount_amount <= 0) {
                    $discount_amount = 0;
                }
                break;
            case "percentage":
                $discount_amount = $cartSubtotal * 0.01 * $amount;
                if ($discount_amount > $max_cap)
                    $discount_amount = $max_cap;
                break;
        }

        return round($discount_amount, 2);
    }

    /**
     * @param $orderUid
     * @return bool
     */
    public function removePromoCode($orderUid)
    {
        $order = Order::where('order_uid', $orderUid)->first();
        if ($order) {
            $order->promo_code = null;
            UserPromoCode::where(['order_uid' => $orderUid])->delete();

            $order->discounts = Arr::except($order->discounts, ['promo_discount']);
            if ($order->save()) {
                $order->net_amount = $order->cart_subtotal - array_sum(array_values($order->discounts));
                $order->save();
                return true;

            }
        }
    }

    /**
     * reddem points
     * @param $orderUid
     * @param $userId
     * @return bool
     */
    public function redeemLPoints(string $orderUid, int $userId)
    {
        $loyalPoint = LoyaltyPointTransaction::where('user_id', $userId)->latest()->first();
        info($loyalPoint);
        if (!$loyalPoint || $loyalPoint->net_amount == 0) {
            return false;
        }
        $order = Order::where('order_uid', $orderUid)->first();

        $loyalPointToAmountRate = 1;
        $siteConfig             = SiteConfig::where('key', 'PURCHASE_LOYALTY_CONVERSION_RATE')->first();
        if ($siteConfig) {
            $loyalPointToAmountRate = $siteConfig->value;
        }
        info($siteConfig);
        $loyalPointAmt = $loyalPointToAmountRate * $loyalPoint->net_amount;
        info($loyalPointAmt);
        if ($order) {
            if ($loyalPointAmt >= $order->net_amount) {
                $discount = $order->net_amount;
            } else {
                $discount = $loyalPointAmt;
            }
            info($discount);
            $order->fill(['discounts->loyaltyPoint' => $discount]);
            $order->net_amount         = $order->cart_subtotal - array_sum(array_values($order->discounts));
            $order->loyalty_point_used = $loyalPoint->net_amount;
            $order->save();
            info($order);
            return true;
        }

        return false;
    }

    /**
     * @param string $orderUid
     * @param int $userId
     * @return mixed
     */
    public function removeRedeemPoints(string $orderUid, int $userId)
    {
        $order = Order::where('order_uid', $orderUid)->first();
        if (!isset($order->discounts['loyaltyPoint'])) {
            return false;
        }
        $discounts = $order->discounts;
        unset($discounts['loyaltyPoint']);
        $order->update(['discounts' => $discounts]);
        $order->net_amount         = $order->cart_subtotal - array_sum(array_values($order->discounts));
        $order->loyalty_point_used = null;
        $order->save();
        return $order;
    }


    public function cartPriceData($productId, $storeId, $size, $unit)
    {
        $storeProductStockUnit = StoreProductStockUnit::with('storeProductStock')
            ->whereHas('storeProductStock', function ($query) use ($productId, $storeId, $size) {
                $query->where(['store_id' => $storeId, 'product_id' => $productId]);
            })
            ->where('quant_unit', $size)
            ->where('unit', $unit)
            ->first();

        return $storeProductStockUnit;
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function showAvailablePromoCodes($param = [])
    {
        $promoCodes = PromoCode::where($param)
            ->where(function ($q) {
                $q->where('start_time', '<=', Carbon::now());
                $q->where('end_time', '>=', Carbon::now());
            })
            ->where('coupon_remained', '>', 0)->get();
        return $promoCodes;
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function getOrder($param = [])
    {
        return Order::where($param)->get();
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function fetchUserPromoCode($param = [])
    {
        return UserPromoCode::where($param)->get();
    }


    public function increasePopularity($productIds = [])
    {
        $availableProductIds = Popularity::whereIn('product_id', $productIds)->get('product_id')->pluck('product_id');
        $notAvailable        = array_diff($productIds, $availableProductIds);
        $productService      = new ProductService(new Product());
       
        $productService->getProducts(['id' => $notAvailable]);
        // find cate
    }

    /**
     * @param (optional) label
     * @return mixed
     */
    public function fetchLoyaltyPointsExchangeInfo($label = null)
    {
        $label = $label ?? ConfigLabelType::LoyalityPointExchangeRate;
        return SiteConfig::where('label', $label)->get();
    }

    /**
     * clear cart service.
     * @param array $param
     * @return mixed
     */
    public function clearCart(array $param)
    {
        return Cart::where($param)->delete();
    }

}
