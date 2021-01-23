<?php

namespace App\Models;

use App\Modules\Store\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreEarning extends Model
{
    protected $table = "store_earning";


    public function order()
    {
        return $this->belongsTo(Order::class,'order_uid','order_uid');
    }


    protected $guarded = [];

    /**
     * getStoreEarningList
     * @param  : condition arr
     */

    public static function getStoreEarningList($condition)
    {
        info($condition);
        $data = StoreEarning::where('store_id', $condition['store_id'])
                ->when(!empty($condition['search']),function($query) use ($condition)
                {
                    $query->where('order_uid','like', '%' . $condition['search'] . '%');
                })
            // ->whereBetween(DB::raw('date(created_at)'), [$condition['start'], $condition['end']])
            ->when($condition['end'], function ($query, $endDate) {
                return $query->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
            })
            ->when($condition['start'], function ($query, $startDate) {
                return $query->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
            })
            ->when($condition['status'],function($query) use ($condition) {

                 $query->where('status',$condition['status']);
            })

            ->paginate(config('constants.PAGINATE'));


        return $data;
    }


    public static function getStoreEarningAmount($condition = [])
    {


        $data = StoreEarning::where('store_id',Auth::guard('store')->user()->id)
                ->get();
        $totalActualAmount = $data->sum('actual_amount');
        $totalCommissionAmount = $data->sum('commission');
        $sum = $totalActualAmount-$totalCommissionAmount;
        return $sum;
        // StoreEarning::select(DB::raw('SUM(amount_received - TRUNCATE((amount_received * commison_percentage) / 100,2)) as amount_after_commission'))

        //     ->join('store_commisions', function ($join) {

        //         $join->on('store_earning.store_id', '=', 'store_commisions.store_id');
        //     })

        //     ->where('store_earning.store_id', $condition['store_id'])

        //     ->whereBetween(DB::raw('date(store_earning.created_at)'), [$condition['start'], $condition['end']])

        //     ->groupBy('store_earning.id')

        //     ->first();

    }


    public static function getStoreOutStadingAmount($condition  = [])
    {


       return StoreEarning::where('store_id',Auth::guard('store')->user()->id)
                ->where('status', 'open')
                ->sum('commission');
        
        // select(DB::raw('SUM(TRUNCATE((amount_received * commison_percentage) / 100,2)) as commission_sum'))

        //     ->join('store_commisions', function ($join) {

        //         $join->on('store_earning.store_id', '=', 'store_commisions.store_id');
        //     })

        //     ->where('store_earning.store_id', $condition['store_id'])

        //     ->where('store_earning.status', 'open')

        //     ->whereBetween(DB::raw('date(store_earning.created_at)'), [$condition['start'], $condition['end']])

        //     ->groupBy('store_earning.id')

        //     ->first();


        // return $data;
    }


    public static function checkStoreCommision($condition)
    {
        return StoreCommision::where('store_id',$condition['store_id'])->first();
    }

    public static function getEarningByOrder($condition = [])
    {
        return StoreEarning::where('store_id',$condition['store_id'])->Where('order_uid', 'like', '%' . $condition['search'] . '%')->get();

    }


     /*
     * Column Position in data table
     */
    protected static $storeEarningTableDataSort = [
        1 => "orders.created_at",
    ];

    public static function getSettlement(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
        $orderColumn = self::$storeEarningTableDataSort[$orderBy['column']];
        $decryptId = decrypt($filter['encryptStoreId']);
        $list = StoreEarning::
            select('store_earning.id AS store_earning_id', 
            'store_earning.order_uid', 
            'store_earning.store_id',
            'store_earning.actual_amount', 
            'store_earning.amount_received', 
            'store_earning.commission', 
            'store_earning.status',
            'store_earning.settlement_at',
            'orders.order_status',
            'orders.discounts',
            'orders.id',
            'orders.cart_subtotal',
            'orders.created_at',
            'orders.order_data')
            ->join('orders', function ($join) {

                $join->on('orders.order_uid', '=', 'store_earning.order_uid');
            })
            ->where('store_earning.store_id',$decryptId)
            ->when($searchLike,function($query)use($searchLike){
                    $query->where('store_earning.order_uid','like', '%' . $searchLike . '%');
            })
            // ->where('store_earning.status',config('constants.STATUS.OPEN'))
            ->orderBy($orderColumn, $orderBy['dir'])
            ->when($filter['endDate'], function ($query, $endDate) {
                 $query->where('orders.created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
            })
            ->when($filter['startDate'], function ($query, $startDate) {
                 $query->where('orders.created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
            })
            ->when($filter['status'], function ($query, $status) {
                return $query->where('store_earning.status', $status);
            });;
       
        
        $storeData['filteredCount'] =  $list->count();
        $storeData['data']          =  $list->limit($limit)
                                            ->offset($offset)
                                            ->get();
        $totalCountFields           = "SQL_NO_CACHE count(id) total";
        $storeData['totalCount']    = StoreEarning::selectRaw($totalCountFields)
                                      ->where('store_earning.store_id',$decryptId)
                                      ->value("total") ?? 0;
        return $storeData;
    }
}
