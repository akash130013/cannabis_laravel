<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Services\SearchService;
use App\Http\Services\StoreService;
use App\Transformers\SearchTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * @var searchService
     * @var storeService
     */
    protected $searchService, $storeService;

    /**
     * SearchService constructor.
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService, StoreService $storeService)
    {
        $this->searchService = $searchService;
        $this->storeService = $storeService;
    }


    public function index(Request $request)
    {
        try {
            $param = [
                'search_type' => $request->search_type,
                'search'      => $request->search,
                'user_id'     => $request->user()->id,
                'pagesize'    => $request->pagesize ?? config('constants.PAGINATE'),
                'status'      => 'active',
                'api'         => trim($request->search) == "" ? false : true,
            ];

            if ($request->has("latitude") && $request->has('longitude')) {
                $param['latitude']  = $request->latitude;
                $param['longitude'] = $request->longitude;
            }
            $recentSearchedId = $this->searchService->fetchSearchData(['user_id' => $request->user()->id, 'searched_type' => $request->search_type])->pluck('searched_id');
            switch ($request->search_type) {
                case 1: // product
                    if (count($recentSearchedId) > 0 && empty($request->search)){
                        $param['in_product_id'] = $recentSearchedId;
                        if ($request->has("latitude") && $request->has('longitude')) {
                            unset($param['latitude']);
                            unset($param['longitude']);
                        }
                    }
                    if (empty($request->search)){
                        $param['is_trending'] = config('constants.YES');
                    }
                    $searchData         = $this->searchService->fetchProducts($param);
                    if (count($searchData['data']) == 0){
                        unset($param['latitude']);
                        unset($param['longitude']);
                        $searchData         = $this->searchService->fetchProducts($param);
                    }
                    $searchData['data'] = SearchTransformer::TransformProductCollection($searchData);
                    break;

                case 2: // store
                    if (count($recentSearchedId) > 0 && empty($request->search)){
                        $param['in_store_id'] = $recentSearchedId;
                        if ($request->has("latitude") && $request->has('longitude')) {
                            unset($param['latitude']);
                            unset($param['longitude']);
                        }
                    }
                    $searchData         = $this->searchService->fetchStores($param);
                    $searchData['data'] = SearchTransformer::TransformStoreCollection($searchData, $param);
                    break;

                default: // category
                    if (count($recentSearchedId) > 0){
                        $param['in_category_id'] = $recentSearchedId;
                    }
                    $stores = $this->storeService->getStoreDetails(Arr::only($param, ['longitude', 'latitude']))->pluck('store_id');
                    if (count($stores) > 0){
                        $param['in_store_id'] = $stores;
                    }
                    $searchData         = $this->searchService->fetchCategories($param);
                   
                    $searchData['data'] = SearchTransformer::TransformCategoryCollection($searchData, $param);
                    break;
            }

            $searchData['search'] = $request->search ?? '';
           
            return response()->jsend($data = $searchData, $presenter = null, $status = "success", $message = "global search list", $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->request->add(['user_id' => $request->user()->id]);
            $validator = \Validator::make($request->all(), [
                'term' => 'max:191',
                'searched_type' => 'required',
                'searched_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $status = $this->searchService->saveSearch($request->all());
            if ($status){
                return response()->jsend($data = $status, $presenter = null, $status = "success", $message = "search data stored", $code = config('constants.SuccessCode'));
            }
            return response()->jsend_error(new \Exception("unsuccessful"), $message = null);

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }
}
