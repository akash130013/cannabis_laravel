<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Search;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Store\Models\StoreDetails;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SearchService
{
    public function fetchProducts($param = [])
    {
        $storeIds = null ;
        // get store which are available in location
        if (Arr::has($param, ['longitude', 'latitude'])){
//            $param['search'] = null;
            $storeIds  = $this->fetchStores(Arr::only($param, ['longitude', 'latitude', 'search']))->pluck('store_id');
            if (count($storeIds) > 0){
                $param['in_store_id'] = $storeIds;
            }
        }
        $products = CategoryProduct::with(['getCategory', 'getImage', 'getProductStock'])
            ->select('id', 'category_id', 'product_name')
//            ->addSelect(DB::raw(implode(',', $storeIds).' as storeIds' ))
            ->when(isset($param['search']), function ($query) use ($param) {
                $query->where('product_name', 'LIKE', '%' . $param['search'] . '%');
            })
            ->when(isset($param['is_trending']), function ($query)use ($param){
                $query->where('is_trending', $param['is_trending']);

            })
            ->has('getProductStock')
            ->where('status', 'active')
            ->when(isset($param['in_product_id']), function ($query)use ($param){
                $query->whereIn('id', $param['in_product_id']);
            })
            ->whereHas('getProductStock', function ($query)use ($param){
                $query->where('status', 'active')
                    ->when(isset($param['in_store_id']), function ($q)use ($param){
                   $q->whereIn('store_id', $param['in_store_id']);
                });
            })
            ->whereHas('getCategory',function($query) use ($param){
                $query->where('status','active');
            });
        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api']) && $param['api'] == true) {
                $products = CommonHelper::restPagination($products->paginate($param['pagesize']));
            } else if (isset($param['api']) && $param['api'] == false) {
                $products = CommonHelper::restPagination($products->paginate(5), $finish = true);
            } else {

                $products = $products->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {

            $products = $products->get();
        }

        return $products;
    }


    public function fetchStores($param = [])
    {
        $stores = StoreDetails::with(['store', 'store_images'])
            ->select('store_id', 'store_name', 'formatted_address')
            ->when(isset($param['search']), function ($query) use ($param) {
                $query->where('store_name', 'LIKE', '%' . $param['search'] . '%');
            })
            ->when((isset($param['longitude']) && isset($param['latitude']) && is_null($param['search'])), function ($q) use ($param) {
                return $q->whereRaw(DB::raw("(6379 * acos( cos( radians(" . $param['latitude'] . ") ) * cos( radians( lat ) )  *  cos( radians( lng ) - radians(" . $param['longitude'] . ") ) + sin( radians(" . $param['latitude'] . ") ) * sin(radians( lat ) ) ) ) <= " . config('constants.store_radius') . " "));
            })
            ->whereHas('store', function ($query) {
                return $query->where('status', 'active')->where('is_admin_approved', config('constants.YES'));
            })
            ->when(isset($param['in_store_id']), function ($query)use ($param){
                $query->whereIn('store_id', $param['in_store_id']);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api']) && $param['api'] == true) {
                $stores = CommonHelper::restPagination($stores->paginate($param['pagesize']));
            } else if (isset($param['api']) && $param['api'] == false) {
                $stores = CommonHelper::restPagination($stores->paginate(5), $finish = true);
            } else {

                $stores = $stores->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {

            $stores = $stores->get();
        }

        return $stores;
    }


    public function fetchCategories($param = [])
    {
        $categories = Category::with('getActiveProduct.getProductStock')
            ->where('status', 'active')
            ->has('getActiveProduct.getProductStock')
            ->when(isset($param['search']), function ($query) use ($param) {
                $query->where('category_name', 'LIKE', '%' . $param['search'] . '%');
            })
           ->when(isset($param['in_category_id']), function ($query) use ($param) {
                $query->whereIn('id', $param['in_category_id']);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api']) && $param['api'] == true) {
                $categories = CommonHelper::restPagination($categories->paginate($param['pagesize']));
            } else if (isset($param['api']) && $param['api'] == false) {
                $categories = CommonHelper::restPagination($categories->paginate(5), $finish = true);
            } else {

                $categories = $categories->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {

            $categories = $categories->get();
        }

        return $categories;
    }

    /**
     * save search data in search table
     * @param array $param
     * @return mixed
     */
    public function saveSearch($param = [])
    {
        $search = Search::firstOrNew(['searched_type' => $param['searched_type'], 'searched_id' => $param['searched_id'],  'user_id' => $param['user_id']]);
        $search->term = $param['term'];
        if (Arr::has($param, 'longitude')){
            $search->longitude = $param['longitude'];
        }
        if (Arr::has($param, 'latitude')){
            $search->latitude = $param['latitude'];
        }
        $search->increment('iteration');
        return $search->save();

    }

    public function fetchSearchData($param = [])
    {
        return Search::where($param)->get();
    }
}
