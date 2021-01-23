<?php


namespace App\Modules\Store\Models;

use App\Models\Category;
use App\Models\StoreDetail;
use App\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreProductStock extends Model
{
    protected $table = "store_product_stock";

    const ACTIVE_PRODUCTS = 'active';

    protected $fillable = [
        'product_id', 'store_id', 'available_stock', 'total_stock', 'status', 'price_range', 'min', 'max', 'pro_desc'
    ];


    /**
     * getProductListing
     * @param : array of filters
     * @return : array of objects
     */

    public static function getProductListing($condition = [])
    {

        $query = StoreProductStock::with(['product' => function ($query) use ($condition) {
            $query->with('getCategory');
        }])->whereHas('product', function ($query) use ($condition) {
            if (isset($condition['search'])) {
                $query->where('product_name', 'LIKE', '%' . $condition['search'] . '%');
            }
        })->whereHas('product.getCategory', function ($query) use ($condition) {
            if (isset($condition['category'])) {
                $query->whereIn('category_id', $condition['category']);
            }
        })->with(['currentstock'])->where('store_id', Auth::guard('store')->user()->id);

        if (isset($condition['stock']) && $condition['stock'] == config('constants.STOCK.INSTOCK')) {  //for instock
            $query->where('available_stock', '>', 0);
        }
        if (isset($condition['stock']) && $condition['stock'] == config('constants.STOCK.OUTSTOCK')) {  //for out of stock
            $query->where('available_stock', '=', 0);
        }

        $query->orderBy('status','asc')->orderBy('created_at', 'desc');

        return $query->paginate(config('constants.PAGINATE'))->appends($condition);
    }


    /**
     * getStoreProductByID
     * @param : stock id
     * @return : applications/json
     */

    public static function getStoreProductByID($id, $condition = [])
    {

        $query = self::with(['product' => function ($query) use ($condition) {

            $query->with('getCategory');

            $query->with('getImage');
        }])
            ->with(['currentstock'])
            ->where('id', $id);

        return $query->first();
    }


    /**
     * getProductNameAndCategory
     * @param : search term
     * @return : result array
     */

    public static function getProductNameAndCategory($condition)
    {

        $query = Category::leftjoin('category_products', function ($join) {

            $join->on('category.id', '=', 'category_products.category_id')
                ->join('store_product_stock', function ($join) {

                    $join->on('store_product_stock.product_id', '=', 'category_products.id')
                        ->where('store_id', Auth::guard('store')->user()->id);
                });
        })->where('product_name', 'LIKE', '%' . $condition['search'] . '%')
          ->where('category_products.status','active');

        return $query->get();
    }

    /**
     * getPackingStoreCount
     * @param : product ID
     * @return : result array
     */
    public static function getPackingStoreCount($produtID)
    {

        $data                      = [];
        $data['store_product']     = StoreProductStock::where('product_id', $produtID)->count();
        $data['store_package_sum'] = StoreProductStock::where('product_id', $produtID)->sum('available_stock');

        return $data;
    }

    public function currentstock()
    {
        return $this->hasMany('App\Modules\Store\Models\StoreProductStockUnit', 'stock_id', 'id');
    }

    public function product()
    {
        return $this->hasOne('App\Modules\Admin\Models\CategoryProduct', 'id', 'product_id')->where('status', self::ACTIVE_PRODUCTS)->orderBy('avg_rate', 'desc');
    }

    public function store()
    {
        return $this->hasOne('App\Store', 'id', 'store_id');
    }

    public function storeDetail()
    {
        return $this->hasManyThrough(StoreDetail::class, Store::class, 'id', 'store_id', 'store_id');
    }

    /**
     * Store Delievery locations
     */
    public function delivery()
    {
        return $this->hasMany('App\Modules\Store\Models\StoreDeliveryAddress', 'store_id', 'store_id');
    }

    /**
     * getProductListing
     * @param : array of filters
     * @return : array of objects
     */

    public static function getProductListingByOffer($condition = [])
    {

        $query = StoreProductStock::with(['product' => function ($query) use ($condition) {

            $query->with('getImage');
        }])
            ->whereHas('product', function ($query) use ($condition) {
                if (!empty($condition['search'])) {
                    $query->where('product_name', 'LIKE', '%' . $condition['search'] . '%');
                }
            })
            ->whereHas('product.getCategory', function ($query) use ($condition) {
                if (!empty($condition['category'])) {
                    $query->where('category_id', $condition['category']);
                }
            })->where('store_id', Auth::guard('store')->user()->id);

        $query->orderBy('created_at', 'desc');

        return $query->get();
    }

    /**
     * getAvailableStoreOffers
     * @param : condition array
     * @return : application/html
     */

    public static function getAvailableStoreOffers($condition = [])
    {
        return StoreProductStock::select('*', DB::raw('(
            CASE
                    WHEN (offer_start > CURRENT_DATE())  THEN "Upcoming"
                    WHEN (offer_end < CURRENT_DATE()) THEN "Expire"
                    ELSE "Live"
                END
                ) as offer_status'))
            ->with('product')
            ->where('store_id', $condition['store_id'])
            ->whereHas('product', function ($query) use ($condition) {

                $query->when($condition['search'], function ($q) use ($condition) {
                    $q->Where('product_name', 'LIKE', '%' . $condition['search'] . '%');
                });
            })
            ->whereNotNUll('offer_start')
            ->when(($condition['start']), function ($query) use ($condition) {

                $query->whereDate('offer_start', '>=', $condition['start']);
            })
            ->when(($condition['end']), function ($query) use ($condition) {
                $query->whereDate('offer_start', '<=', $condition['end']);

            })
            ->when(($condition['status']), function ($query) use ($condition) {
                $query->having('offer_status', $condition['status']);
            })
            ->orderBy('created_at', 'desc')
            ->simplepaginate(config('constants.PAGINATE'));
    }


    /**
     * @desc used to get search offer by name
     */
    public static function getOfferNameByProduct($condition = [])
    {

        $query = StoreProductStock::with('product')
            ->whereHas('product', function ($query) use ($condition) {

                if (!empty($condition['search'])) {

                    $query->where('product_name', 'LIKE', '%' . $condition['search'] . '%');
                }
            })
            ->whereNotNUll('offer_start')
            ->where('store_id', $condition['store_id']);


        $query->orderBy('created_at', 'desc');

        return $query->get();
    }

    public function scopeWithOrderBy($query, $orderType)
    {
        return $query->whereHas('products', function ($q) use ($orderType) {
            $q->withOrderBy($orderType);
        });
    }

    public function ratings()
    {

    }
}
