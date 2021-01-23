<?php


namespace App\Modules\Admin\Models;

use App\Models\Rating;
use DB;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = "category_products";

    protected $fillable = [
        'category_id',
        'product_name',
        'quantity_json',
        'product_desc',
        'thc_per',
        'cbd_per',
        'status',
        'avg_rate'
    ];

    protected static $productTableDataSort = [
        1 => "category_products.id",
        2 => "category_products.product_name",


    ];

    protected static $productRatingTableDataSort = [
        1 => "ratings.id",
        2 => "ratings.rate",


    ];

    /**
     * getProductImagesDataByID
     * @param : productid
     * @return : row data
     */

    public static function getProductImagesDataByID($id)
    {
        $query = CategoryProduct::select(
            'category_products.id',
            'category_products.category_id',
            'category_products.product_name',
            'category_products.quantity_json',
            'category_products.product_desc',
            'category_products.thc_per',
            'category_products.cbd_per',
            'category_products.status',
            'category_product_images.file_url',
            'category.category_name',
            'category.image_url'
        )

            ->join('category', 'category.id', '=', 'category_products.category_id')

            ->leftjoin('category_product_images', 'category_product_images.product_id', '=', 'category_products.id')


            ->where('category_products.id', $id);

        return $query->first();
    }


    /***
     * funtion to get product rating and reviews
     *
     *
     */
    public function rating()
    {
        return $this->hasMany(Rating::class, 'rated_id', 'id')->where('type', 'product');
    }

    public function getCategory()
    {
        return $this->hasOne('App\Modules\Admin\Models\Category', 'id', 'category_id');
    }

    // public function getActiveCategory()
    // {
    //     return $this->hasOne('App\Modules\Admin\Models\Category', 'id', 'category_id')->where('status','active');
    // }


    public function getImage()
    {
        return $this->hasMany('App\Modules\Admin\Models\CategoryProductImages', 'product_id', 'id');
    }

    public function getProductStock()
    {

        return $this->hasMany('App\Modules\Store\Models\StoreProductStock', 'product_id', 'id');
    }

    public function getRatingReviews()
    {
        return $this->hasMany('App\Models\Rating', 'rated_id', 'id')
            ->where('type', 'product');
    }
    /***
     * to get average rating of products
     *
     *
     */

    public function getAvgRating()
    {
        return $this->getRatingReviews()->selectRaw('rated_id,round(AVG(ratings.rate),1) AS average_rating');
    }
    // /****
    //  * Defining scope store wise to get category product data.
    //  * @param: store id
    //  * @return: boolean
    //  * 
    //  */
    // public function scopeWitStore($query, $storeId)
    // {
    //     return $query->
    // }



    /**
     * To fetch user data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */

    public static function getCategoryProductData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
        $selectFields = " SQL_CALC_FOUND_ROWS category_products.id,
                            category_products.category_id,
                            category_products.product_name, 
                            category_products.status, 
                            category.category_name, 
                            category_products.created_at,
                            category_products.total_placed_order";
                           

        $orderColumn = self::$productTableDataSort[$orderBy['column']];
        $list = CategoryProduct::selectRaw($selectFields)
            ->withCount('getProductStock')
            ->where(function ($query) use ($filter, $searchLike) {
                $query->when(
                    $searchLike,
                    function ($query, $searchLike) {
                        $query->Where('category_products.product_name', 'like', '%' . $searchLike . '%')
                            ->orWhere('category_products.id', 'like', $searchLike . '%');
                    }
                );
            })
            ->leftJoin('category', 'category_products.category_id', 'category.id')
            // ->leftJoin('category_product_images', 'category_products.id', 'category_product_images.product_id')
            ->when($filter['store_id'], function ($query, $store_id) {
                return $query->whereHas('getProductStock', function ($q) use ($store_id) {
                    $q->where('store_id', $store_id);
                });
            })
            ->when($filter['status'], function ($query, $status) {
                return $query->where('category_products.status', $status);
            })
            ->when($filter['category_id'], function ($query, $category_id) {
                return $query->whereIn('category.id', $category_id);
            })
            ->when($filter['min_order'], function ($query, $min_order) {
                return $query->where('category_products.total_placed_order', '>=', $min_order);
            })
            ->when($filter['max_order'], function ($query, $max_order) {
                return $query->where('category_products.total_placed_order', '<=', $max_order);
            })
            ->when($filter['minStore'], function ($query, $minStore) {
                return $query->having('get_product_stock_count', '>=', $minStore);
            })
            ->when($filter['maxStore'], function ($query, $maxStore) {
                return $query->having('get_product_stock_count', '<=', $maxStore);
            });
            // ->distinct('category_products.id');
        // ->groupBy('category_products.id');
        // ->where('category_products.status','!=','deleted');

        $productData['filteredCount']   =  $list->count();
        $productData['data']            =  $list->offset($offset)
                                            ->orderBy($orderColumn, $orderBy['dir'])
                                            ->limit($limit)
                                            ->get();
        $totalCountFields               = "SQL_NO_CACHE count(id) total";
        $productData['totalCount']      = CategoryProduct::selectRaw($totalCountFields)
                                            ->when($filter['store_id'], function ($query, $store_id) {
                                                return $query->whereHas('getProductStock', function($q) use($store_id)
                                                    {
                                                        $q->where('store_id',$store_id);
                                                    });
                                            })
                                            ->value("total") ?? 0;
        return $productData;
    }

    /**
     * showProductList
     * @param : category and search term
     */

    public static function showProductList($condition = [])
    {


        $query =  CategoryProduct::select('category_products.*')->where('product_name', 'LIKE', '%' . $condition['search'] . '%')

            ->join('category', 'category.id', '=', 'category_products.category_id')

            ->leftJoin('store_product_stock', function ($join) use ($condition) {


                $join->on('store_product_stock.product_id', '=', 'category_products.id');

                $join->where('store_product_stock.store_id', $condition['store_id']);
            })

            ->whereNull('store_product_stock.product_id')

            ->where('category.status', 'active')

            ->where('category_products.status', 'active')

            ->where(function ($query) use ($condition) {
                if (!empty($condition['category'])) {
                    $query->where('category_products.category_id', $condition['category']);
                }
            });


        return $query->get();
    }


    /****
     * get ratings list product wise
     * @param: offset, length, search, orderBy & filters
     * @return : application/json
     *
     *
     */

    public static function getProductRatingsData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
        $decryptProductId   = decrypt($filter['encryptProductId']);
        $orderColumn        = self::$productRatingTableDataSort[$orderBy['column']];
        $productRatingData['data'] = Rating::when(
            $searchLike,
            function ($query, $searchLike) {
                $query->where(function ($query) use ($searchLike) {

                    $query->where('review', 'like', '%' . $searchLike . '%')

                        ->orWhereHas('user', function ($q) use ($searchLike) {
                            $q->where('name', 'like', '%' . $searchLike . '%');
                        })
                        ->orWhereHas('order', function ($q) use ($searchLike) {
                            $q->Where('order_uid', 'like', '%' . $searchLike . '%');
                        });
                });
            }
        )
            ->when($filter['endDate'], function ($query, $endDate) {
                return  $query->whereHas('order', function ($q) use ($endDate) {
                    $q->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                });
            })
            ->when($filter['startDate'], function ($query, $startDate) {
                return  $query->whereHas('order', function ($q) use ($startDate) {
                    $q->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                });
            })
            ->when($filter['minRate'], function ($query, $minRate) {
                return $query->having('rate', '>=', $minRate);
            })
            ->when($filter['maxRate'], function ($query, $maxRate) {
                return $query->having('rate', '<=', $maxRate);
            })
            ->orderBy($orderColumn, $orderBy['dir'])
            ->offset($offset)
            ->where('rated_id', '=', $decryptProductId)
            ->where('type', 'product')
            ->limit($limit)
            ->get();
        $productRatingData['data']->load('user', 'order');
        $productRatingData['filteredCount'] = Rating::where('rated_id', $decryptProductId)
            ->where('type', 'product')
            ->selectRaw("FOUND_ROWS() total")->value("total") ?? 0;
        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $productRatingData['totalCount'] = Rating::where('rated_id', $decryptProductId)
            ->where('type', 'product')
            ->selectRaw($totalCountFields)->value("total") ?? 0;
        return $productRatingData;
    }


    public function scopeWithProduct($query, $productStockId)
    {
        return $query->whereHas('getProductStock', function ($q) use ($productStockId) {
            $q->where('id', $productStockId);
        });
    }

    public function scopeWithOrderBy($query, $orderType)
    {
        return $query->whereHas('ratings', function ($q) use ($orderType) {
            $q->orderBy('rate');
        });
    }
}
