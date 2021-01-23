<?php


namespace App\Transformers;


use App\Helpers\CommonHelper;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Modules\Store\Models\StoreProductStock;
use Illuminate\Support\Arr;

class ProductTransformer
{

    
    public static function TransformCollection($products)
    {
        $productService = new ProductService(new Product());
        $filteredData   = collect($products['data'])->map(function ($item) use ($productService) {
            $tmpItem                 = new \stdClass();   //empty class object
            $tmpItem->id             = $item['id'];
            $tmpItem->product_name   = $item['product_name'];
            $tmpItem->quantity_json  = $item['quantity_json'];
            $tmpItem->category_name  = $item['category']['category_name'];
            $tmpItem->status         = $item['status'] ?? 'blocked';
            $tmpItem->price_range    = $productService->productPriceRange($item['id']);
            $tmpItem->product_images = $item['product_images'];
            $tmpItem->is_wishlisted  = CommonHelper::checkWishList($item['id'], request()->user()->id);
            $tmpItem->rating         = CommonHelper::fetchAvgRating($item['id'], 'product');
            $tmpItem->review         = CommonHelper::ratingReviewCount($item['id'], 'product');
            $tmpItem->review_count   = CommonHelper::ratingReviewCount($item['id'], 'product', 'review');

            return $tmpItem;
        });
        return $filteredData;
    }

    public static function TransformStoreProductCollection($products, $unique = null)
    {
        $products = collect($products['data']);
        if ($unique) {
            $products = $products->unique($unique)->values();
        }
        $filteredData = $products->map(function ($item) {
            $tmpItem                          = new \stdClass();
            $tmpItem->id                      = $item['product_id'];
            $tmpItem->product_name            = @$item['product']['product_name'];
            $tmpItem->avg_rate                = @$item['product']['avg_rate'];
            $tmpItem->quantity_json           = json_decode(@$item['product']['quantity_json']);
            $tmpItem->store_id                = @$item['store_id'];
            $tmpItem->store_name              = @$item['store_detail'][0]['store_name'];
            $tmpItem->store_image             = @$item['store']['store_images'][0]['file_url'];
            $tmpItem->category_id             = @$item['product']['category_id'];
            $tmpItem->category_name           = @$item['product']['get_category']['category_name'];
            $tmpItem->status                  = $item['product']['status'];
            $tmpItem->price_range             = $item['price_range'];
            $tmpItem->offer_range             = $item['offer_range'];
            $tmpItem->product_images          = @$item['product']['get_image'];
            $tmpItem->pro_desc                = $item['pro_desc'];
            $tmpItem->is_wishlisted           = CommonHelper::checkWishList($item['product_id'], request()->user()->id);
            $tmpItem->rating                  = CommonHelper::fetchAvgRating($item['product_id'], 'product');
            $tmpItem->review                  = CommonHelper::ratingReviewCount($item['product_id'], 'product');
            $tmpItem->rating_count            = CommonHelper::ratingReviewCount($item['product_id'], 'product');
            $tmpItem->review_count            = CommonHelper::ratingReviewCount($item['product_id'], 'product', 'review');
            $tmpItem->current_stock           = ProductTransformer::currentStockConversion($item['product_id'], $item['store_id']);
            $tmpItem->is_sold_out             = CommonHelper::checkSoldOutProduct($item['product_id'], $item['store_id']);
            $tmpItem->max_discount_percentage = !empty(Arr::pluck($tmpItem->current_stock, 'discount_percentage')) ?  (int)max(Arr::pluck($tmpItem->current_stock, 'discount_percentage')) :0;
           
            return $tmpItem;
        });
        return $filteredData;
    }


    public static function TransformStoreProduct($product, $is_available_current_location = true)
    {
        $tmpItem                                = new \stdClass();
        $tmpItem->id                            = $product->product_id;
        $tmpItem->product_name                  = @$product->product->product_name;
        $tmpItem->quantity_json                 = json_decode(@$product->product->quantity_json);
        $tmpItem->category_name                 = @$product->product->getCategory->category_name;
        $tmpItem->status                        = $product->product->status;
        $tmpItem->price_range                   = $product->price_range;
        $tmpItem->product_images                = @$product->product->getImage;
        $tmpItem->pro_desc                      = $product->pro_desc;
        $tmpItem->pro_desc_admin                = @$product->product->product_desc;
        $tmpItem->thc_per                       = $product->product->thc_per;
        $tmpItem->cbd_per                       = $product->product->cbd_per;
        $tmpItem->is_available                  = ($product->available_stock > 0) ? config('constants.STOCK.INSTOCK') : config('constants.STOCK.OUTSTOCK');
        $tmpItem->category                      = @$product->product->getCategory;
        $tmpItem->currentstock                  = @$product->currentstock;
        $tmpItem->store_id                      = @$product->storeDetail->first()->store_id;
        $tmpItem->store_name                    = @$product->storeDetail->first()->store_name;
        $tmpItem->is_wishlisted                 = CommonHelper::checkWishList($product->product_id, request()->user()->id);
        $tmpItem->rating                        = CommonHelper::fetchAvgRating($product->product_id, 'product');
        $tmpItem->review_count                  = CommonHelper::ratingReviewCount($product->product_id, 'product', 'review');
        $stock_data                             = $product->currentstock->pluck('quant_unit', 'id')->toArray();
        $tmpItem->is_cartAdded                  = false;
        $tmpItem->is_cartAdded_data             = CommonHelper::checkCartAdded($product->product_id, request()->user()->id, $tmpItem->store_id, $stock_data);
        $tmpItem->is_available_current_location = $is_available_current_location;
        return $tmpItem;
    }


    public static function TransformCollectionSimilarProducts($products)
    {
        $productService = new ProductService(new Product());
        $filteredData   = collect($products['data'])->map(function ($item) use ($productService) {
            $tmpItem                 = new \stdClass();
            $tmpItem->id             = $item['id'];
            $tmpItem->product_name   = $item['product_name'];
            $tmpItem->category_id    = $item['category']['id'];
            $tmpItem->category_name  = $item['category']['category_name'];
            $tmpItem->status         = $item['status'];
            $tmpItem->price_range    = $productService->productPriceRange($item['id']);
            $tmpItem->product_images = $item['product_images'];
            $tmpItem->is_wishlisted  = CommonHelper::checkWishList($item['id'], request()->user()->id);
            $tmpItem->rating         = CommonHelper::fetchAvgRating($item['id'], 'product');
            $tmpItem->review         = CommonHelper::ratingReviewCount($item['id'], 'product');
            $tmpItem->review_count   = CommonHelper::ratingReviewCount($item['id'], 'product', 'review');
            $tmpItem->product_images = Arr::pluck($item['product_images'], 'file_url');
            if (request()->has('latitude') && request()->has('longitude')) {
                $param                = [
                    'latitude'   => request()->latitude,
                    'longitude'  => request()->longitude,
                    'product_id' => $item['id'],
                ];
                $store                = $productService->getStoreByLocationProductId($param);
                $tmpItem->store_name  = @$store->store_name;
                $tmpItem->store_id    = @$store->store_id;
                $tmpItem->store_image = @CommonHelper::getFirstStoreImage($store->store_id);
            }
            return $tmpItem;
        })->reject(function ($q) {
            return is_null($q->store_name);
        });
        return $filteredData;
    }

    /**
     *
     * @param array $stock
     * @return array
     */
    protected static function currentStockConversion($productId, $storeId)
    {
        $data = [];
        $stock = StoreProductStock::where(['product_id' => $productId, 'store_id' => $storeId])->first()->currentstock;
        foreach ($stock as $key => $value) {
            $data[$key] = Arr::except($value, ['created_at', 'updated_at']);
            if (is_null($value['offered_price']) || ($value['offered_price'] >= $value['actual_price'])) {
                $discountPercentage = null;
            } else {
                $discountPercentage = round((($value['actual_price'] - $value['offered_price']) * 100 / $value['actual_price']), 2);
            }
            $data[$key]['discount_percentage'] = $discountPercentage;
        }
        return $data;
    }

}
