<?php


namespace App\Transformers;


use App\Helpers\CommonHelper;
use App\Store;
use Illuminate\Support\Arr;

class BookmarkTransformer
{
    public static function TransformCollection($bookmarks)
    {
        $store        = new Store();
        $filteredData = collect($bookmarks['data'])->map(function ($item) use ($store) {
            $tmpItem                 = new \stdClass();
            $tmpItem->store_id       = $item['store_id'];
            $store                   = $store->find($item['store_id']);
            $tmpItem->store_name     = $store->storeDetail->store_name;
            $tmpItem->store_images   = Arr::pluck($store->storeImages, 'file_url');
            $tmpItem->rating         = CommonHelper::fetchAvgRating($item['store_id'], 'store');
            $tmpItem->review_count   = CommonHelper::ratingReviewCount($item['store_id'], 'store', 'review');
            $tmpItem->address        = $store->storeDetail->formatted_address;
            $tmpItem->contact_number = $store->storeDetail->contact_number;
            $opening_timing          = CommonHelper::todayStoreTiming($item['store_id']);
            $tmpItem->opening_timing = $opening_timing['opening_timing'];
            $tmpItem->is_open        = $opening_timing['openingStatus'];
            $tmpItem->is_bookmarked  = true;
            return $tmpItem;
        });
        return $filteredData;


    }

}
