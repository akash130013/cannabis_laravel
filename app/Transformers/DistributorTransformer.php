<?php


namespace App\Transformers;


use App\Helpers\CommonHelper;
use App\Store;
use Illuminate\Support\Arr;

class DistributorTransformer
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
            $tmpItem->rating         = CommonHelper::fetchAvgRating($item['store_id'], 'store') ;
            $tmpItem->review_count   = CommonHelper::ratingReviewCount($item['store_id'], 'store');
            $tmpItem->address        = $store->storeDetail->formatted_address;
            $tmpItem->contact_number = $store->storeDetail->contact_number;
            $opening_timing          = CommonHelper::todayStoreTiming($item['store_id']);
            $tmpItem->opening_timing = $opening_timing['opening_timing'];
            $tmpItem->is_open        = $opening_timing['openingStatus'];
            $tmpItem->is_bookmarked  = CommonHelper::checkBookMark($item['store_id'], request()->user()->id);
            return $tmpItem;
        });
        return $filteredData;


    }


    public static function TransformObject($distributor)
    {
        $tmpItem                        = new \stdClass();
        $tmpItem->id                    = $distributor->id;
        $tmpItem->name                  = $distributor->name;
        $tmpItem->gender                = $distributor->gender;
        $tmpItem->country_code          = $distributor->country_code;
        $tmpItem->phone_number          = $distributor->phone_number;
        $tmpItem->phone_number_verified = is_null($distributor->phone_number_verified_at) ? false : true;
        $tmpItem->email                 = $distributor->email;
        $tmpItem->profile_image         = $distributor->profile_image;
        $tmpItem->address               = $distributor->address;
        $tmpItem->city                  = $distributor->city;
        $tmpItem->state                 = $distributor->state;
        $tmpItem->zipcode               = $distributor->zipcode;
        $tmpItem->dl_number             = $distributor->dl_number;
        $tmpItem->dl_expiraion_date     = $distributor->dl_expiraion_date;
        $tmpItem->vehicle_number        = $distributor->vehicle_number;
        $tmpItem->vehicle_images        = Arr::pluck($distributor->getVehicleImage, 'file_url');
        $tmpItem->status                = $distributor->status;
        $tmpItem->rating                = CommonHelper::fetchAvgRating($distributor->id, 'driver');
        $tmpItem->proof                 = $distributor->proofs;
        return $tmpItem;
    }

}
