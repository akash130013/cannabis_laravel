<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $guarded = [];

    /**
     * The function is to use soft delete of data
     */

    use SoftDeletes;


    /**
     *  this function is used to get users who reedemd coupon
     * 
     */
    public function redeemedUsers()
    {
       return $this->belongsToMany('App\User','user_promo_codes','promo_code','user_id','coupon_code');
    }
    
    
    
    /*
     * Column Position in data table
     */
    protected static $promocodeTableDataSort = [
        1 => "promo_codes.promo_name",
    ];

      /**
     * To fetch promocode data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getPromocodeData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
         $orderColumn = self::$promocodeTableDataSort[$orderBy['column']];

        $list = PromoCode::select('id','promo_name','coupon_code','total_coupon','max_cap','promotional_type','amount','start_time','end_time','offer_status')
            ->where(function ($query) use ($filter, $searchLike) {
                $query->when($searchLike,
                    function ($query, $searchLike) {
                        $query->Where('promo_name', 'like', '%' . $searchLike . '%');
                        $query->orWhere('coupon_code', 'like', '%' . $searchLike . '%');
                    });
            })
            ->when($filter['promotionalType'], function ($query, $promotionalType) {
                return $query->where('promotional_type', $promotionalType);
            })
            
            ->when($filter['maxAmount'], function ($query, $maxAmount) {
                return $query->where('max_cap', '<=', $maxAmount);
            })
            ->when($filter['minAmount'], function ($query, $minAmount) {
                return $query->where('max_cap', '>=', $minAmount);
            });


            if($filter['couponDateType'] == 'start')
            {
               $list =$list->when($filter['endDate'], function ($query, $endDate) {
                    return $query->where('start_time', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                })
                ->when($filter['startDate'], function ($query, $startDate) {
                    return $query->where('start_time', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                });
            }
            else
            {
               $list =$list->when($filter['endDate'], function ($query, $endDate) {
                    return $query->where('end_time', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                })
                ->when($filter['startDate'], function ($query, $startDate) {
                    return $query->where('end_time', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                });
            }


           $list = $list->orderBy($orderColumn, $orderBy['dir'])->where('offer_status','!=','deleted');



        $promocodeData['filteredCount'] = $list->count();
                                    
        $promocodeData['data'] = $list->limit($limit)
                                ->offset($offset)
                                ->get();
        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $promocodeData['totalCount'] = PromoCode::selectRaw($totalCountFields)->value("total") ?? 0;
        return $promocodeData;
    }
}



