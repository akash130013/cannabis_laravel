<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\CommonHelper;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use App\Http\Services\ReviewService;
use App\Http\Services\StoreService;
use App\Models\Product;
use App\Transformers\ProductTransformer;
use App\Transformers\StoreTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    /**
     * @var StoreService
     * @var OrderService
     */
    protected $storeService, $orderService;

    /**
     * StoreController constructor.
     * @param StoreService $storeService
     */
    public function __construct(StoreService $storeService, OrderService $orderService)
    {
        $this->storeService = $storeService;
        $this->orderService = $orderService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getNearStores(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'longitude' => 'required',
                'latitude'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

//            $isStoreOpened = true;
//            if ($request->has('availablity') && ($request->availablity == 3)) {
//                $isStoreOpened = false;
//            }
            $param = [
                'longitude'     => $request->longitude,
                'latitude'      => $request->latitude,
                'pagesize'      => $request->pagesize ?? config('constants.PAGINATE'),
//                'isStoreOpened' => $isStoreOpened,
                'rating'        => $request->rating ?? 'all',
                'search'        => $request->search ?? '',
                'api'           => true,
            ];


            if ($request->has('product_id') && !empty($request->product_id)) {
                $storeIds          = $this->storeService->getStoreIdByProductId($request->product_id);
                $param['storeIds'] = $storeIds;
            }

            if ($request->has('category_id') && !empty($request->category_id)) {
                $category = $request->category_id;
                if (is_string($request->category_id) && stripos($request->category_id, ",")) {
                    $category = explode(",", $request->category_id);
                }
                $storeIds          = $this->storeService->getStoreIdByCategoryId($category);
                $param['storeIds'] = $storeIds;
            }
            $stores         = $this->storeService->getStoreDetails($param);
            $storeStatusString = $rating = null;
            if ($request->has('is_open') && !empty($request->is_open)) {
                $storeStatusString = $request->is_open == 1?"opened":"closed";
            }
            if ($request->has('rating') && !empty($request->rating)){
                $rating = $request->rating;
            }
            $stores['data'] = $stores->isEmpty() ? [] : StoreTransformer::TransformCollectionStoreDetail($stores, $storeStatusString, $rating);
            return response()->jsend($data = $stores, $presenter = null, $status = "success", $message = null, $code = 200);
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $param     = ['store_id' => $id, 'longitude' => \request()->longitude, 'latitude' => \request()->latitude];
            $validator = Validator::make($param, [
                'store_id' => ['required', 'exists:store,id'],
                'longitude' => ['sometimes'],
                'latitude'  => ['required_with:longitude'],

            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $store = $this->storeService->getStoreDetails($param)->first();
            if (!$store){
                return response()->jsend_error(new \Exception("store not available"), $message = null);
            }
            $store = StoreTransformer::TransformObjectStoreDetail($store);

            $paramProduct         = [
                'pagesize'   => config('constants.storePageProductLimit'),
                'store_id'   => $store->store_id,
                'sorting_id' => 1,
                'status'     => 'active',
                'api'        => true,
            ];
            $productService       = new ProductService(new Product);
            $products             = $productService->getStoreProducts($paramProduct);
            $store->first_product = ProductTransformer::TransformStoreProductCollection($products);
            $store->product_count = $productService->countProductByStoreId($id);
            $reviewService        = new ReviewService();
            $store->review        = $reviewService->getReviewObject('store', $id);
            $store->time_table    = $this->storeService->fetchStoreTimeTable($id);
            $store->ratingCount  = CommonHelper::ratingReviewCount($id, config('constants.ratingType.store'));
            $store->reviewStatistics  = $this->orderService->ratingGroupData(['rated_id' => $id, 'type' =>config('constants.ratingType.store')]);

            $store->statisticsData=CommonHelper::getStasticData($id, $id, config('constants.ratingType.store'));
             
            return response()->jsend($data = $store, $presenter = null, $status = "success", $message = null, $code = 200);

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function fetchStoreByProductId(Request $request)
    {
        try {
            $storeIds = $this->storeService->getStoreIdByProductId($request->product_id);
            $param    = [
                'longitude' => $request->longitude,
                'latitude'  => $request->latitude,
                'pagesize'  => $request->pagesize ?? config('constants.PAGINATE'),
                'storeIds'  => $storeIds,
                'api'       => true,
            ];

            $stores         = $this->storeService->getStoreDetails($param);
            $stores['data'] = StoreTransformer::TransformCollectionStoreDetail($stores);
            return response()->jsend($data = $stores, $presenter = null, $status = "success", $message = null, $code = 200);

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('category listing error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }
}
