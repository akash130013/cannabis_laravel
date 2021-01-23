<?php


namespace App\Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use DB; 

class Category extends Model
{
    protected $table = "category";
    
    protected $fillable = [
        'category_name',
        'status',
        'image_url',
        'category_desc',
        'thumb_url',
    ];


    public function getProduct(){
        return $this->hasMany('App\Modules\Admin\Models\CategoryProduct','category_id','id');
    }

    public function getActiveProduct(){
        return $this->hasMany('App\Modules\Admin\Models\CategoryProduct','category_id','id')->where('status','active');
    }
    /*
     * Column Position in data table
     */
    protected static $categoryTableDataSort = [
        1 => "category.id",
        3 => "category.category_name",
      
       
    ];

/**
 * @desc used to get all store category
 */
    public static function getStoreCategory($store_id){
        $category = Category::with('getActiveProduct.getProductStock')
        ->whereHas('getActiveProduct.getProductStock',  function ($query) use ($store_id)  {
                return $query->where('store_id',$store_id);
        })
        ->get();
        return $category;
    }
/**
     * To fetch user data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getCategoryData(int $offset, int $limit, string $searchLike, array $orderBy = [], array $filter)
    {
        $selectFields = " SQL_CALC_FOUND_ROWS category.id,
        category.category_name, category.status, category.created_at,category.image_url";

        //  $orderColumn = self::$categoryTableDataSort[$orderBy['column']];

        $productData['data'] = Category::selectRaw($selectFields)->withCount('getProduct')
            ->where(function ($query) use ($filter, $searchLike) {
                $query->when($searchLike,
                    function ($query, $searchLike) {
                        $query->Where('category.category_name', 'like', '%' . $searchLike . '%')
                            ->orWhere('category.id', 'like', $searchLike . '%');
                    });
            })
            ->when($filter['status'], function ($query, $status) {
                return $query->where('category.status', $status);
            })
            ->when($filter['endDate'], function ($query, $endDate) {
                return $query->where('category.created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
            })
            ->when($filter['startDate'], function ($query, $startDate) {
                return $query->where('category.created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
            })
            ->when($filter['minProduct'], function ($query, $minProduct) {
                return $query->having('get_product_count', '>=', $minProduct);
             })
             ->when($filter['maxProduct'], function ($query, $maxProduct) {
                 return $query->having('get_product_count', '<=', $maxProduct);
              })
            // ->orderBy('created_at','desc')
            ->offset($offset)
            ->where('category.status','!=','deleted')
            ->limit($limit)
            ->get();
        $productData['filteredCount'] = Category::selectRaw("FOUND_ROWS() total")->value("total") ?? 0;
        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $productData['totalCount'] = Category::selectRaw($totalCountFields)->value("total") ?? 0;
        return $productData;
    }

}