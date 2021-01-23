<?php


namespace App\Transformers;


use App\Helpers\CommonHelper;
use App\Store;
use Illuminate\Support\Arr;

/**
 * Class CartTransformer
 * @package App\Transformers
 * @author Sumit Sharma
 */
class CartTransformer
{
    /**
     * @param $cart
     * @return \Illuminate\Support\Collection
     */
    public static function TransformCollection($cart)
    {
        $filteredData = collect($cart)->map(function ($item) {
            $tmpItem                         = new \stdClass();
            $tmpItem->cart_uid               = $item->cart_uid;
            $tmpItem->user_id                = $item->user_id;
            $tmpItem->order_uid              = $item->order_uid;
            $tmpItem->product_id             = $item->product_id;
            $tmpItem->quantity               = $item->quantity;
            $tmpItem->attributes             = $item->attributes;
            $tmpItem->size                   = $item->size;
            $tmpItem->size_unit              = $item->size_unit;
            $tmpItem->product_name           = $item->product->first()->product_name;
            $tmpItem->product_image          = $item->product->first()->product_images->first()->file_url;
            $tmpItem->status                 = $item->product->first()->status;
            $tmpItem->category_name          = $item->product->first()->category->category_name;
            $tmpItem->category_status        = $item->product->first()->category->status;
            $tmpItem->store_id               = $item->store_id;
            $tmpItem->storeDetail            = $item->storeDetail->first()->store_name;
            $calculateCartPrice              = CommonHelper::calculateCartPriceData($item->product_id, $item->store_id, $item->size, $item->size_unit);
            $tmpItem->actual_price           = (int)$calculateCartPrice->actual_price;
            $tmpItem->offered_price          = (int)$calculateCartPrice->offered_price;
            $tmpItem->per_item_selling_price = $calculateCartPrice->offered_price ?? $calculateCartPrice->actual_price;
            $tmpItem->discount               = is_null($calculateCartPrice->offered_price) ? 0 : $calculateCartPrice->actual_price - $calculateCartPrice->offered_price;
            $tmpItem->discountPercent        = is_null($calculateCartPrice->offered_price) ? 0 : round((($tmpItem->discount * 100) / $calculateCartPrice->actual_price), 2);
            $tmpItem->item_subtotal          = $tmpItem->per_item_selling_price * $item->quantity;
            $tmpItem->order_json             = $item->order_json;
            $tmpItem->is_wishlisted          = CommonHelper::checkWishList($item->product_id, request()->user()->id);
            $tmpItem->is_available           = CommonHelper::checkStockAvailable($item->product_id, $item->store_id, $item->size);
            $tmpItem->stock_product           = CommonHelper::productStock($item->product_id, $item->store_id);
            return $tmpItem;
        });
        return $filteredData;
    }

    /**
     * @param $promoCode
     * @return \Illuminate\Support\Collection
     */
    public static function promoCodeTransformerCollection($promoCode)
    {
        $filteredData = collect($promoCode)->map(function ($item) {
            $tmpItem                          = new \stdClass();
            $tmpItem->promo_name              = $item->promo_name;
            $tmpItem->description             = $item->description;
            $tmpItem->coupon_code             = $item->coupon_code;
            $tmpItem->promotional_type        = $item->promotional_type;
            $tmpItem->amount                  = $item->amount;
            $tmpItem->max_redemption_per_user = $item->max_redemption_per_user;
            $tmpItem->max_cap                 = $item->max_cap;
            $tmpItem->start_time              = CommonHelper::convertFormat($item->start_time, 'M d, Y');
            $tmpItem->end_time                = CommonHelper::convertFormat($item->end_time, 'M d, Y');
            return $tmpItem;
        });
        return $filteredData;
    }

    /**
     * loyalty points exchange info transformation.
     * @param $loyaltyPointInfo
     * @return mixed
     */
    public static function loyaltyPointExchangeCollectionTransform($loyaltyPointInfo)
    {
        return $loyaltyPointInfo->map(function ($item) {
            $tmpItem                   = new \stdClass();
            $tmpItem->exchange_package = $item->key . ($item->key == 1 ? " loyalty point" : " loyalty points");
            $tmpItem->exchange_rate    = config('constants.Currency.symbol') . $item->value;
            $tmpItem->status           = $item->status;
            return $tmpItem;
        });

    }
}
