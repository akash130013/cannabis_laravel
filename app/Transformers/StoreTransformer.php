<?php


namespace App\Transformers;


use App\Helpers\CommonHelper;
use Illuminate\Support\Arr;

class StoreTransformer
{

    /**
     * @param $storeDetail
     * @param $openStatusString
     * @param $rating
     * @return \Illuminate\Support\Collection
     */
    public static function TransformCollectionStoreDetail($storeDetail, $openStatusString = null, $rating = null)
    {
        $filteredData = collect($storeDetail['data'])->map(function ($item) use ($openStatusString, $rating) {
            $tmpItem                 = new \stdClass();
            $tmpItem->store_id       = $item['store_id'];
            $tmpItem->store_name     = $item['store_name'];
            $tmpItem->email          = @$item['store']['email'];
            $tmpItem->about_store    = $item['about_store'];
            $tmpItem->latitude       = $item['lat'];
            $tmpItem->longitude      = $item['lng'];
            $tmpItem->store_images   = @Arr::pluck($item['store']['store_images'], 'file_url');
            $tmpItem->rating         = CommonHelper::fetchAvgRating($item['store_id'], 'store');
            $tmpItem->review_count   = CommonHelper::ratingReviewCount($item['store_id'], 'store', 'review');
            $tmpItem->address        = $item['formatted_address'];
            $tmpItem->contact_number = $item['contact_number'];
            $opening_timing          = CommonHelper::todayStoreTiming($item['store_id']);
            $tmpItem->opening_timing = $opening_timing['opening_timing'];
            $tmpItem->closing_timing = $opening_timing['closing_timing'];
            $tmpItem->is_open        = $opening_timing['openingStatus'];
            if (isset($openStatusString)) {
                $openStatus = $openStatusString == "opened" ? true : false;
                if ($openStatus !== $opening_timing['openingStatus']){
                    return;
                }
            }
            if (isset($rating)) {
                if ($tmpItem->rating < $rating){
                    return;
                }
            }
            $tmpItem->is_bookmarked = CommonHelper::checkBookMark($item['store_id'], request()->user()->id);
            $tmpItem->latitude      = $item['lat'];
            $tmpItem->longitude     = $item['lng'];
            if (request()->has('latitude')) {
                $tmpItem->distance = round($item['distance'], 1) . ' Km';
            }
            return $tmpItem;
        });
        return $filteredData->reject(null)->values();
    }

    public static function TransformObjectStoreDetail($storeDetail)
    {
        $tmpItem                 = new \stdClass();
        $tmpItem->store_id       = $storeDetail->store_id;
        $tmpItem->store_name     = $storeDetail->store_name;
        $tmpItem->banner_image_url = $storeDetail->banner_image_url;
        $tmpItem->email          = @$storeDetail->store->email;
        $tmpItem->about_store    = $storeDetail->about_store;
        $tmpItem->latitude       = $storeDetail->lat;
        $tmpItem->longitude      = $storeDetail->lng;
        $tmpItem->store_images   = @Arr::pluck($storeDetail->store->storeImages, 'file_url');
        $tmpItem->rating         = CommonHelper::fetchAvgRating($storeDetail->store_id, 'store');
        $tmpItem->review_count   = CommonHelper::ratingReviewCount($storeDetail->store_id, 'store', 'review');
        $tmpItem->address        = $storeDetail->formatted_address;
        $tmpItem->contact_number = $storeDetail->contact_number;
        $opening_timing          = CommonHelper::todayStoreTiming($storeDetail->store_id);
        $tmpItem->opening_timing = $opening_timing['opening_timing'];
        $tmpItem->closing_timing = $opening_timing['closing_timing'];
        $tmpItem->is_open        = $opening_timing['openingStatus'];
        $tmpItem->is_bookmarked  = CommonHelper::checkBookMark($storeDetail->store_id, request()->user()->id);
        if (request()->has('latitude')) {
            $tmpItem->distance = round(CommonHelper::distance($storeDetail->lat, $storeDetail->lng, request()->latitude, request()->longitude), 1). ' Km';
        }
        return $tmpItem;
    }


}
