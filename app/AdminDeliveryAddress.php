<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AdminDeliveryAddress extends Model
{   
    use Sortable;

    protected $table = "admin_delivery_locations";

    protected $fillable = [
        'address','city','state','zipcode','country','timezone','status'
    ];

    public $sortable = ['id', 'address','city','state','zipcode','country','timezone', 'created_at', 'updated_at'];


    /**
     * showProductList
     * @param : category and search term
     */

    public static function showDeliveryZips($condition = [])
    {

        $query =  AdminDeliveryAddress::where('zipcode', 'LIKE', '%' . $condition['search'] . '%')

                    ->where('status', 'active');

        return $query->get();
    }

       /*
     * Column Position in data table
     */
    protected static $deliveryTableDataSort = [
        1 => "admin_delivery_locations.id",
        3 => "admin_delivery_locations.address",
      
       
    ];

      /**
     * To fetch user data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getdeliverLocationData(int $offset, int $limit, string $searchLike, array $orderBy =[])
    {
        $selectFields = " SQL_CALC_FOUND_ROWS 
        admin_delivery_locations.id,
        admin_delivery_locations.address, 
        admin_delivery_locations.city, 
        admin_delivery_locations.state, 
        admin_delivery_locations.zipcode,
        admin_delivery_locations.country, 
        admin_delivery_locations.timezone, 
        admin_delivery_locations.status, 
        admin_delivery_locations.created_at";
        //  $orderColumn = self::$deliveryTableDataSort[$orderBy['column']];

        $deliveryData['data'] = AdminDeliveryAddress::selectRaw($selectFields)
            ->where(function ($query) use ($searchLike) {
                $query->when($searchLike,
                    function ($query, $searchLike) {
                        $query->orWhere('admin_delivery_locations.city', 'like', '%' . $searchLike . '%');
                        $query->orWhere('admin_delivery_locations.state', 'like', '%' . $searchLike . '%');
                        $query->orWhere('admin_delivery_locations.country', 'like', '%' . $searchLike . '%');
                        $query->orWhere('admin_delivery_locations.zipcode', 'like', '%' . $searchLike . '%');
                    });
            })
            ->orderBy('created_at','desc')
            ->offset($offset)
            ->where('admin_delivery_locations.status','!=','deleted')
            ->limit($limit)
            ->get();
        $deliveryData['filteredCount'] = AdminDeliveryAddress::selectRaw("FOUND_ROWS() total")->value("total") ?? 0;
        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $deliveryData['totalCount'] = AdminDeliveryAddress::selectRaw($totalCountFields)->value("total") ?? 0;
        return $deliveryData;
    }


}
