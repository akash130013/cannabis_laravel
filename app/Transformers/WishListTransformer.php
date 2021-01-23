<?php


namespace App\Transformers;

use App\Helpers\CommonHelper;
use App\Http\Services\ProductService;
use App\Models\Product;

class WishListTransformer
{
    public static function TransformCollection($wishlist)
    {
        $productService = new ProductService(new Product());
        $filteredData   = collect($wishlist['data'])->map(function ($item) use ($productService) {
            $tmpItem                 = new \stdClass();
            $tmpItem->id             = $item['product_id'];
            $tmpItem->product_name   = @$item['product']['product_name'];
            $tmpItem->quantity_json  = json_decode(@$item['product']['quantity_json']);
            $tmpItem->category_name  = @$item['product']['get_category']['category_name'];
            $tmpItem->product_images = @$item['product']['get_image'];
            $tmpItem->rating         = CommonHelper::fetchAvgRating($item['product_id'], 'product');
            $tmpItem->review_count   = CommonHelper::ratingReviewCount($item['product_id'], 'product', 'review');
            $tmpItem->is_wishlisted  = CommonHelper::checkWishList($item['product_id'], request()->user()->id);
            $tmpItem->price_range    = $productService->productPriceRange($item['product_id']);
            return $tmpItem;
        });
        return $filteredData;
    }
}
