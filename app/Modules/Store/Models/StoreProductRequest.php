<?php


namespace App\Modules\Store\Models;

use App\Modules\Admin\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class StoreProductRequest extends Model
{
    protected $table = "store_product_requests";


    protected $fillable = [
    'product_name','store_id', 'thc','cbd','product_desc','status','category_id'
  ];



  protected static $productTableDataSort = [
    1 => "store_product_requests.id",
    2 => "store_product_requests.product_name",

];

public function category()
{
    return $this->hasOne(Category::class,'id','category_id');
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

    public static function getProductRequestedData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
        $selectFields = " SQL_CALC_FOUND_ROWS 
        store_product_requests.id,
        store_product_requests.product_name,
        store_product_requests.thc,
        store_product_requests.cbd, 
        store_product_requests.status,
        store_product_requests.created_at,
        store_details.store_name";

        $orderColumn = self::$productTableDataSort[$orderBy['column']];

        $requestProductData['data'] = StoreProductRequest::selectRaw($selectFields)
            ->where(function ($query) use ($filter, $searchLike) {
                $query->when(
                    $searchLike,
                    function ($query, $searchLike) {
                        $query->Where('store_product_requests.product_name', 'like', '%' . $searchLike . '%')
                            ->orWhere('store_product_requests.id', 'like', $searchLike . '%');
                    }
                );
            })
           
            ->leftJoin('store_details', 'store_product_requests.store_id', 'store_details.store_id')

            ->when($filter['status'], function ($query, $status) {
                return $query->where('store_product_requests.status', $status);
            })
            ->when($filter['category_id'], function ($query, $category_id) {
                return $query->where('category.id', $category_id);
            })
            ->when($filter['endDate'], function ($query, $endDate) {
                return $query->where('store_product_requests.created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
            })
            ->when($filter['startDate'], function ($query, $startDate) {
                return $query->where('store_product_requests.created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
            })
           
            ->groupBy('store_product_requests.created_at')
            ->orderBy($orderColumn, $orderBy['dir'])
            ->offset($offset)
            ->limit($limit)
            ->where('status','pending')
            ->get();
        $requestProductData['filteredCount'] = StoreProductRequest::selectRaw("FOUND_ROWS() total")->value("total") ?? 0;
        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $requestProductData['totalCount'] = StoreProductRequest::selectRaw($totalCountFields)
                                            ->where('status','pending')
                                            ->value("total") ?? 0;
        return $requestProductData;
    }



    
     /**
     * getProductListing
     * @param : array of filters
     * @return : array of objects
     */

    public static function getStoreRequestedProduct($condition = [])
    {
      
        $query = StoreProductRequest::with('category');
            
        $query->orderBy('created_at', 'desc')->where('store_id', Auth::guard('store')->user()->id);

        return $query->paginate(config('constants.PAGINATE'))->appends($condition);
    }


}