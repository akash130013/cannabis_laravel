<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use App\Http\Services\ReviewService;
use App\Transformers\ProductTransformer;
use App\Transformers\RatingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    protected $productService;
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     * @param OrderService $orderService
     */
    public function __construct(ProductService $productService, OrderService $orderService)
    {
        $this->productService = $productService;
        $this->orderService   = $orderService;
    }

    public function trendingProducts(Request $request)
    {
        try {

            $param            = [
                'pagesize'    => $request->pagesize ?? config('constants.PAGINATE'),
                'is_tranding' => 1,
                'status'      => 'active',
                'api'         => true,
            ];
            $products         = $this->productService->getProducts($param);
            $products['data'] = ProductTransformer::TransformCollection($products);

            return response()->jsend($data = $products, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

    /**
     * products listing based on conditions
     * @param Request $request
     * @return mixed
     */
    public function storeProducts(Request $request)
    {
        try {
            $param = [
                'pagesize'           => $request->pagesize ?? config('constants.PAGINATE'),
                'store_id'           => $request->store_id,
                'filter_id'          => $request->filter_id,
                'sorting_id'         => $request->sorting_id,
                'stock_availability' => $request->stock_availability,
                'price_range'        => $request->price_range,
                'cannabis_type'      => $request->cannabis_type,
                'search'             => $request->search,
                'is_trending'        => $request->is_trending,
                'zipcode'            => $request->zipcode,
                'status'             => 'active',
                'product_id'         => $request->product_id,
                'longitude'          => $request->longitude,
                'latitude'           => $request->latitude,
                'api'                => true,
            ];
            if ($request->has('dealonly')) {
                $param['dealonly'] = true;
            }
            $products                     = $this->productService->getStoreProducts($param);
            $products['data']             = ProductTransformer::TransformStoreProductCollection($products, $request->unique);
            $filterMinMaxPrices           = $this->productService->filterMinMaxPrices();
            $products['filter_min_price'] = @$filterMinMaxPrices->StartFrom;
            $products['filter_max_price'] = @$filterMinMaxPrices->EndTo;

            return response()->jsend($data = $products, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }
    }

    /**
     * Product Detail Api
     * @param $request
     * @return mixed
     */
    public function storeProductById(Request $request)
    {
        try {
           
            $param = [
                'pagesize'  => $request->pagesize ?? config('constants.PAGINATE'),
                'id'        => $request->id,
                'store_id'  => $request->store_id,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'status'    => 'active',
                'api'       => true,
                'is_available_current_location' => true,
            ];
         
            $validator = Validator::make($param, [
                'id' => 'required|exists:store_product_stock,product_id',
            ]);

            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $product = $this->productService->getStoreProductById($param);
            if(!$product){
                unset($param['latitude']);
                unset($param['longitude']);
                $param['is_available_current_location'] = false;
                $product = $this->productService->getStoreProductById($param);
            }
            if (!$product) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $product = ProductTransformer::TransformStoreProduct($product, $param['is_available_current_location']);
            $store = $this->productService->getFirstStoreByProductID($param);

            if (!$store) {
                $product->store = null;
            } else {
                $opening_timing = CommonHelper::todayStoreTiming(@$store->store->storeDetail->store_id);
                $storeData      = [
                    'store_id'       => @$store->store->storeDetail->store_id,
                    'store_name'     => @$store->store->storeDetail->store_name,
                    'store_contact'  => @$store->store->storeDetail->contact_number,
                    'address'        => @$store->store->storeDetail->formatted_address,
                    'store_images'   => Arr::pluck(@$store->store->storeImages, 'file_url'),
                    'latitude'       => @$store->store->storeDetail->lat,
                    'longitude'      => @$store->store->storeDetail->lng,
                    'is_open'        => @$opening_timing['openingStatus'],
                    'is_bookmarked'  => CommonHelper::checkBookMark(@$store->store->storeDetail->store_id, request()->user()->id),
                    'rating'         => @CommonHelper::fetchAvgRating($store->store->storeDetail->store_id, 'store'),
                    'review_count'   => @CommonHelper::ratingReviewCount($store->store->storeDetail->store_id, 'store', 'review'),
                    'closing_timing' => @$opening_timing['closing_timing'],
                    'opening_timing' => @$opening_timing['opening_timing'],
                    'openingStatus'  => @$opening_timing['openingStatus'],
                    'distance'       => @round(CommonHelper::distance($store->store->storeDetail->lat, $store->store->storeDetail->lng, request()->latitude, request()->longitude), 1) . ' Km'

                ];
                $product->store = $storeData;
            }
            $product->total_selling_stores = $this->productService->countStoreByProductId(@$request->id, $request->longitude, $request->latitude);

            if ($request->has('user_type') && $request->user_type == "web"){
                $ratings = $this->orderService->getRating(['type' => 'product', 'rated_id' => $param['id'], 'pagesize' => config('constants.USER_WEB_PRODUCT_DETAIL_REVIEW_LIMIT')]);
                $product->reviews = RatingTransformer::TransformReviewCollection($ratings, true);
//                return response()->json($ratings);
            }else{
                $rating = $this->orderService->getRating(['type' => 'product', 'rated_id' => $param['id']])->first();
                $product->reviews = RatingTransformer::TransformReviewObject($rating);
            }
            $product->reviewStatistics  = $this->orderService->ratingGroupData(['rated_id' => $request->id, 'type' =>config('constants.ratingType.product')]);
            $product->ratingCount  = CommonHelper::ratingReviewCount($request->id, config('constants.ratingType.product'));

            $product->statisticsData=CommonHelper::getStasticDataProduct($request->id, $request->store_id, config('constants.ratingType.product'));
           
            return response()->jsend($data = $product, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function fetchSimilarProduct(Request $request)
    {
        try {
            $validator = \Validator::make(['product_id' => $request->product_id], [
                'product_id' => 'exists:category_products,id',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $productCategory = $this->productService->getProducts(['id' => $request->product_id])->first();

            $products = $this->productService->getProducts([
                'pagesize'    => $request->pagesize ?? config('constants.PAGINATE'),
                'category_id' => $productCategory->category_id,
                'status'      => 'active',
                'excludeIds'  => [$request->product_id],
                'api'         => true,
            ]);


            $products['data'] = ProductTransformer::TransformCollectionSimilarProducts($products);

            return response()->jsend($data = $products, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));


        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }
}
