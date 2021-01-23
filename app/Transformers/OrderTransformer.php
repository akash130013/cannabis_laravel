<?php


namespace App\Transformers;

use App\Helpers\CommonHelper;
use Illuminate\Support\Arr;

/**
 * Class OrderTransformer
 * @package App\Transformers
 * @author Sumit Sharma
 */
class OrderTransformer
{
    /**
     * transform order data
     * @param $orders
     * @return \Illuminate\Support\Collection
     */
    public static function TransformCollection($orders)
    {
        $filteredData = collect($orders['data'])->map(function ($item) {
            $tmpItem                             = new \stdClass();
            $tmpItem->order_created_date         = $item['created_at'];
            $tmpItem->cartSummary                = $item['order_data']['cartSummary'];
            $tmpItem->additional_charges         = $item['additional_charges'];
            $tmpItem->order_status               = $item['order_status'];
            $tmpItem->discounts                  = $item['discounts'] ?? [];
            $tmpItem->order_uid                  = $item['order_uid'];
            $tmpItem->cancel_by                  = $item['cancel_by'];
            $tmpItem->net_amount                 = $item['net_amount'];
            $tmpItem->itemCount                  = $item['order_data']['itemCount'];
            $tmpItem->delivery_address           = $item['order_data']['delivery_address'];
            $tmpItem->store_id                   = $item['store_id'];
            $store                               = CommonHelper::getStoreData($item['store_id']);
            $tmpItem->store_status               = @$store->status;
            $tmpItem->store_name                 = @$store->storeDetail->store_name;
            $tmpItem->store_images               = @Arr::pluck($store->storeDetail->store_images, 'file_url');
            $tmpItem->rating                     = CommonHelper::fetchAvgRating($item['store_id'], 'store');
            $tmpItem->review_count               = CommonHelper::ratingReviewCount($item['store_id'], 'store', 'review');
            $tmpItem->store_address              = @$store->storeDetail->formatted_address;
            $tmpItem->contact_number             = @$store->storeDetail->contact_number;
            $opening_timing                      = CommonHelper::todayStoreTiming($item['store_id']);
            $tmpItem->opening_timing             = $opening_timing['opening_timing'];
            $tmpItem->closing_timing             = $opening_timing['closing_timing'];
            $tmpItem->is_open                    = $opening_timing['openingStatus'];
            $tmpItem->latitude                   = @$store->storeDetail->lat;
            $tmpItem->longitude                  = @$store->storeDetail->lng;
            $tmpItem->distributor_id             = @$item['distributors'][0]['id'];
            $tmpItem->distributor_name           = @$item['distributors'][0]['name'];
            $tmpItem->distributor_profile_image  = @$item['distributors'][0]['profile_image'];
            $tmpItem->distributor_contact        = @$item['distributors'][0]['country_code'] . ' ' . @$item['distributors'][0]['phone_number'];
            $tmpItem->distributor_working_status = @$item['distributors'][0]['working_status'];
            $tmpItem->schedule_date              = @$item['distributors'][0]['pivot']['schedule_date'];
            $tmpItem->delivery_time              = @$item['delivered_at'];
            $tmpItem->is_rated                   = (bool)CommonHelper::fetchRatingData(['order_uid' => $item['order_uid']])->count();
            return $tmpItem;
        });
        return $filteredData;
    }

    public static function TransformObject($order)
    {
        $tmpItem                             = new \stdClass();
        $tmpItem->order_created_date         = $order->created_at->format('Y-m-d H:i:s');
        $tmpItem->cartSummary                = $order->order_data['cartSummary'];
        $tmpItem->additional_charges         = $order->additional_charges;
        $tmpItem->discounts                  = $order->discounts;
        $tmpItem->order_status               = $order->order_status;
        $tmpItem->order_uid                  = $order->order_uid;
        $tmpItem->net_amount                 = $order->net_amount;
        $tmpItem->itemCount                  = $order->order_data['itemCount'];
        $tmpItem->delivery_address           = $order->order_data['delivery_address'];
        $tmpItem->store_id                   = $order->store_id;
        $store                               = CommonHelper::getStoreData($order->store_id);
        $tmpItem->store_name                 = @$store->storeDetail->store_name;
        $tmpItem->store_images               = @Arr::pluck($store->storeDetail->store_images, 'file_url');
        $tmpItem->rating                     = @CommonHelper::fetchAvgRating($order->store_id, 'store');
        $tmpItem->review_count               = @CommonHelper::ratingReviewCount($order->store_id, 'store', 'review');
        $tmpItem->store_address              = @$store->storeDetail->formatted_address;
        $tmpItem->contact_number             = @$store->storeDetail->contact_number;
        $opening_timing                      = CommonHelper::todayStoreTiming($order->store_id);
        $tmpItem->opening_timing             = $opening_timing['opening_timing'];
        $tmpItem->closing_timing             = $opening_timing['closing_timing'];
        $tmpItem->is_open                    = $opening_timing['openingStatus'];
        $tmpItem->latitude                   = @$store->storeDetail->lat;
        $tmpItem->longitude                  = @$store->storeDetail->lng;
        $tmpItem->distributor_id             = @$order->distributors->first()->id;
        $tmpItem->distributor_name           = @$order->distributors->first()->name;
        $tmpItem->distributor_profile_image  = @$order->distributors->first()->profile_image;
        $tmpItem->distributor_contact        = @$order->distributors->first()->country_code . ' ' . @$order->distributors->first()->phone_number;
        $tmpItem->distributor_working_status = @$order->distributors->first()->working_status;
        $tmpItem->schedule_date              = @$order->distributors->first()->pivot->schedule_date;
        $tmpItem->is_rated                   = (bool)CommonHelper::fetchRatingData(['order_uid' => $order->order_uid])->count();
        $tmpItem->delivery_time              = @$order->delivered_at;
        return $tmpItem;
    }

    /**
     * transform driver order data
     * @param $orders
     * @return \Illuminate\Support\Collection
     */
    public static function TransformCollectionDeliveryOrders($orders)
    {
        $filteredData = collect($orders['data'])->map(function ($item) {
            $tmpItem                                   = new \stdClass();
            $tmpItem->distributor_current_order_rating = @CommonHelper::fetchRatingData(['order_uid' => $item['order_uid'], 'type' => 'driver'])->first()->rate;
            $tmpItem->order_status                     = $item['order_status'];
            $tmpItem->cartSummary                      = $item['order_data']['cartSummary'];
            $tmpItem->additional_charges               = $item['additional_charges'];
            $tmpItem->discounts                        = $item['discounts'];
            $tmpItem->order_uid                        = $item['order_uid'];
            $tmpItem->net_amount                       = $item['net_amount'];
            $tmpItem->itemCount                        = $item['order_data']['itemCount'];
            $tmpItem->delivery_address                 = $item['delivery_address'];
            $tmpItem->store_id                         = $item['store_id'];
            $store                                     = CommonHelper::getStoreData($item['store_id']);
            $tmpItem->storeDetail['store_name']        = $store->storeDetail->store_name;
            $tmpItem->storeDetail['store_images']      = Arr::pluck($store->storeDetail->store_images, 'file_url');
            $tmpItem->storeDetail['rating']            = CommonHelper::fetchAvgRating($item['store_id'], 'store');
            $tmpItem->storeDetail['review_count']      = CommonHelper::ratingReviewCount($item['store_id'], 'store');
            $tmpItem->storeDetail['address']           = $store->storeDetail->formatted_address;
            $tmpItem->storeDetail['contact_number']    = $store->storeDetail->contact_number;
            $opening_timing                            = CommonHelper::todayStoreTiming($item['store_id']);
            $tmpItem->storeDetail['opening_timing']    = $opening_timing['opening_timing'];
            $tmpItem->storeDetail['closing_timing']    = $opening_timing['closing_timing'];
            $tmpItem->storeDetail['is_open']           = $opening_timing['openingStatus'];
            $tmpItem->storeDetail['latitude']          = $store->storeDetail->lat;
            $tmpItem->storeDetail['longitude']         = $store->storeDetail->lng;
            $tmpItem->order_delivery_schedule          = @$item['distributors'][0]['pivot']['schedule_date'];
            return $tmpItem;
        });
        return $filteredData;
    }

    public static function TransformObjectDeliveryOrder($order)
    {
        $tmpItem                                   = new \stdClass();
        $tmpItem->distributor_current_order_rating = @CommonHelper::fetchRatingData(['order_uid' => $order->order_uid, 'type' => 'driver'])->first()->rate;
        $tmpItem->cartSummary                      = $order->order_data['cartSummary'];
        $tmpItem->order_status                     = $order->order_status;
        $tmpItem->additional_charges               = $order->additional_charges;
        $tmpItem->discounts                        = $order->discounts;
        $tmpItem->order_uid                        = $order->order_uid;
        $tmpItem->net_amount                       = $order->net_amount;
        $tmpItem->itemCount                        = $order->order_data['itemCount'];
        $tmpItem->delivery_address                 = $order->order_data['delivery_address'];
        $tmpItem->store_id                         = $order->store_id;
        $tmpItem->storeDetail['store_name']        = $order->stores->storeDetail->store_name;
        $tmpItem->storeDetail['store_images']      = Arr::pluck($order->stores->storeDetail->store_images, 'file_url');
        $tmpItem->storeDetail['address']           = $order->stores->storeDetail->formatted_address;
        $tmpItem->storeDetail['contact_number']    = $order->stores->storeDetail->contact_number;
        $opening_timing                            = CommonHelper::todayStoreTiming($order->store_id);
        $tmpItem->storeDetail['opening_timing']    = $opening_timing['opening_timing'];
        $tmpItem->storeDetail['closing_timing']    = $opening_timing['closing_timing'];
        $tmpItem->storeDetail['is_open']           = $opening_timing['openingStatus'];
        $tmpItem->storeDetail['latitude']          = $order->stores->storeDetail->lat;
        $tmpItem->storeDetail['longitude']         = $order->stores->storeDetail->lng;
        $tmpItem->storeDetail['rating']            = CommonHelper::fetchAvgRating($order->store_id, 'store');
        $tmpItem->storeDetail['reviewCount']       = CommonHelper::ratingReviewCount($order->store_id, 'store');
        $tmpItem->order_delivery_schedule          = @$order->distributors->first()->pivot->schedule_date;
        $tmpItem->distributor_id                   = @$order->distributors->first()->id;
        $tmpItem->distributor_name                 = @$order->distributors->first()->name;
        $tmpItem->distributor_profile_image        = @$order->distributors->first()->profile_image;
        $tmpItem->distributor_avg_rating           = isset($order->distributors->first()->id) ? @CommonHelper::fetchAvgRating($order->distributors->first()->id, 'driver') : 0;
        return $tmpItem;

    }

}
