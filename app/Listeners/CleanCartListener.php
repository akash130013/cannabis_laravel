<?php

namespace App\Listeners;

use App\Events\PostPlaceOrderEvent;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Services\CartService;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\PromoCode;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreProductStockUnit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CleanCartListener
{
    /**
     * @var CartController
     */
    protected $cartController;
    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * Create the event listener.
     * @param $cartController
     * @param $cartService
     * @return void
     */
    public function __construct(CartController $cartController, CartService $cartService)
    {
        $this->cartController = $cartController;
        $this->cartService    = $cartService;
    }

    /**
     * Handle the event.
     *
     * @param PostPlaceOrderEvent $event
     * @return void
     */
    public function handle(PostPlaceOrderEvent $event)
    {
        $order = Order::where(['order_uid' => $event->orderUid])->first();
        if (!is_null($order->promo_code)) {
            $promoCode = PromoCode::where('coupon_code', $order->promo_code)->first();
            $promoCode->decrement('coupon_remained');
            $promoCode->save();
        }


        $cart = Cart::where(['order_uid' => $event->orderUid, 'user_id' => $event->userId])->get();
        // increase popularity ranks
        //        $productIds = $cart->pluck('product_id')->toArray();
        //        $data = $this->cartService->increasePopularity($productIds);
        //        if (is_array($productIds)){
        //            dd('array');
        //        }else{
        //            var_dump($productIds->toArray());
        //            dd('jsfjksdnf');
        //        }

        foreach ($cart as $key => $value) {
            OrderDetail::create([
                'order_id'   => $order->id,
                'order_uid'  => $order->order_uid,
                'product_id' => $value->product_id,
                'quantity'   => $value->quantity,
                'unit'       => $value->size,
                'size'       => $value->size_unit,
            ]);

        }

        $cartData = $this->cartController->showCart($event->userId);
        $cartData = json_decode(json_encode($cartData))->original->data;

        Order::where(['order_uid' => $event->orderUid, 'user_id' => $event->userId])->update(['order_data' => json_encode($cartData)]);


        // increment entry for product_id
        foreach ($cartData->cartListing as $key => $value) {
            $product = Product::find($value->product_id);
            if ($product) {
                $product->total_placed_order = $product->total_placed_order + $value->quantity;
                $product->save();

                $storeProductStock = StoreProductStock::where(['product_id' => $value->product_id, 'store_id' => $value->store_id])->first();
                if ($storeProductStock) {
                    $stock = StoreProductStockUnit::where('stock_id', $storeProductStock->id)->where(['quant_unit' => $value->size, 'unit' => $value->size_unit])->first();
                    $stock->decrement('total_stock', $value->quantity);
                    $stock->save();
                    $storeProductStock->decrement('available_stock', $value->quantity);
                    $storeProductStock->save();
                }

            }
        }
        Cart::where(['order_uid' => $event->orderUid, 'user_id' => $event->userId])->delete();

        // promo code redemption


    }
}
