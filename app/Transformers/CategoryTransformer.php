<?php


namespace App\Transformers;


use App\Helpers\CommonHelper;

class CategoryTransformer
{
    public static function TransformCollection($categories)
    {
        return collect($categories['data'])->map(function ($item) {
            $tmpItem                      = new \stdClass();
            $tmpItem->id                  = $item['id'];
            $tmpItem->category_name       = $item['category_name'];
            $tmpItem->image_url           = $item['image_url'];
            $tmpItem->status              = $item['status'];
            $tmpItem->category_desc       = $item['category_desc'];
            $tmpItem->thumb_url           = $item['thumb_url'];
            $tmpItem->product_availability = CommonHelper::checkProductAvailability($item['id']);
            return $tmpItem;
        });
    }
}
