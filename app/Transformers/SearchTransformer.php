<?php


namespace App\Transformers;

use Illuminate\Support\Arr;

class SearchTransformer
{
    public static function TransformProductCollection($searchData)
    {
        $filteredData = collect($searchData['data'])->map(function ($item) {
            $tmpItem                       = new \stdClass();
            $tmpItem->product_id           = $item['id'];
            $tmpItem->encrypted_product_id = encrypt($item['id']);
            $tmpItem->product_name         = @$item['product_name'];
            $tmpItem->product_image        = @$item['get_image'][0]['file_url'];
            $tmpItem->category_name        = @$item['get_category']['category_name'];
            return $tmpItem;
        });
        return $filteredData;
    }


    public static function TransformStoreCollection($searchData)
    {
        $filteredData = collect($searchData['data'])->map(function ($item) {
            $tmpItem                     = new \stdClass();
            $tmpItem->store_id           = $item['store_id'];
            $tmpItem->encrypted_store_id = encrypt($item['store_id']);
            $tmpItem->store_name         = $item['store_name'];
            $tmpItem->address            = $item['formatted_address'];
            $tmpItem->store_images       = @Arr::pluck($item['store_images'], 'file_url');
            return $tmpItem;
        });
        return $filteredData;
    }


    public static function TransformCategoryCollection($searchData, $param = [])
    {
        $filteredData = collect($searchData['data'])->map(function ($item) use ($param) {
            
            $tmpItem                = new \stdClass();
            $tmpItem->id            = $item['id']; // category_id
            $tmpItem->encrypted_id  = encrypt($item['id']);
            $tmpItem->category_name = $item['category_name'];
            $tmpItem->category_name = $item['category_name'];
            $tmpItem->product_count = SearchTransformer::countProductInStock($item['get_active_product'], $param);
            $tmpItem->image_url     = @$item['image_url'];
            $tmpItem->category_desc = @$item['category_desc'];
            $tmpItem->thumb_url     = @$item['thumb_url'];
            
            return $tmpItem;
        });
        
        return $filteredData;
    }

    protected static function countProductInStock($data, $param = [])
    {
        // dd($param);
        $productCount = 0;
        foreach ($data as $value) {
            if (!empty($value['get_product_stock'])) {
                if (isset($param['in_store_id'])){
                    if (collect($value['get_product_stock'])->whereIn('store_id', $param['in_store_id'])->where('status', 'active')->count() > 0)
                        $productCount++;
                }
            }
        }
        return $productCount;
    }
}
