<?php

namespace App\Models;

use App\Store;
use App\Models\Distributor;
use App\Models\OrderDetail;
use App\Helpers\CommonHelper;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'additional_charges' => 'array',
        'discounts' => 'array',
        'delivery_address' => 'array',
        'order_data'    => 'array',
    ];

    public function stores()
    {
        return $this->belongsTo('App\Store', 'store_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function distributors()
    {
        return $this->belongsToMany(Distributor::class)->withPivot('schedule_date');
    }

    public function distributorsOrder()
    {
        return $this->belongsTo('App\Models\Distributor');
    }

    public function getOrderedProducts()
    {
        return $this->hasMany('App\Models\OrderDetail','order_uid','order_uid');
    }
     /*
     * Column Position in data table
     */
    protected static $tableDataSort = [
        1 => "orders.created_at",


    ];

      /**
     * To fetch distributor order data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getOrderListData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter, $distributorId,$userId,$storeId,$productId)
    {
         $distributorId      = $distributorId !=null? (int) $distributorId:null;
         $userId             = $userId !=null? (int) $userId:null;
         $storeId            = $storeId !=null? (int) $storeId:null;
         $orderColumn        = self::$tableDataSort[$orderBy['column']];
         if(null != $distributorId)
        {
            $list = Order::select('id','order_uid','delivery_address','net_amount','created_at','order_data','schedule_date','payment_method','order_status')
                                ->whereHas('distributors',function ($query) use($distributorId){
                                            $query->where('distributor_id',$distributorId);
                                        });

        }
        else{
            $list = Order::orWhereHas('user',function($query)use($searchLike)
                                    {
                                        $query->when($searchLike,function($q,$searchLike)
                                        {
                                            $q->where('name', 'like', '%' . $searchLike . '%');
                                        });
                                    })
                                    ->when($storeId, function($query, $storeId)
                                    {
                                        return $query->whereHas('stores',function($q) use ($storeId)
                                        {
                                            $q->where('store_id',$storeId);
                                        });
                                    })
                                    ->when($userId, function($query, $userId)
                                    {
                                        return $query->whereHas('user',function($q) use ($userId)
                                        {
                                            $q->where('id',$userId);
                                        });
                                    });

        }
        $list =  $list->orWhere(function ($query) use ($filter, $searchLike) {
                                        $query->when($searchLike,
                                            function ($query, $searchLike) {
                                                $query->orWhere('order_uid', 'like', '%' . $searchLike . '%');
                                            });
                                    })
                                    ->when($filter['endDate'], function ($query, $endDate) {
                                         $query->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                                    })
                                    ->when($filter['startDate'], function ($query, $startDate) {
                                         $query->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                                    })
                                    ->when($filter['status'], function ($query, $status) {
                                         $query->whereIn('order_status',CommonHelper::getStatusArray($status));
                                    })
                                    ->when($filter['maxAmount'], function ($query, $maxAmount) {
                                         $query->where('net_amount','<=', $maxAmount);
                                    })
                                    ->when($filter['minAmount'], function ($query, $minAmount) {
                                         $query->where('net_amount','>=', $minAmount);
                                    })
                                    ->when($productId,function($query,$productId)
                                    {
                                        $query->where('order_data->cartListing->product_id',$productId);
                                    })
                                    ->where('order_status','!=','init');

        $orderData['filteredCount'] =  $list->count();

        $orderData['data']          = $list->offset($offset)
                                        ->orderBy($orderColumn, $orderBy['dir'])
                                        ->limit($limit)
                                        ->get();
        if(null == $distributorId)
        {
            $list->pluck('id',
                                        'order_uid',
                                        'delivery_address',
                                        'net_amount',
                                        'created_at',
                                        'payment_method',
                                        'order_status','user','stores');
        }

        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $orderData['totalCount'] = Order::selectRaw($totalCountFields)
                                    ->when($filter['status'], function ($query, $status) {
                                        return $query->whereIn('order_status',CommonHelper::getStatusArray($status));
                                    })
                                    ->when($storeId, function($query, $storeId)
                                    {
                                        return $query->whereHas('stores',function($q) use ($storeId)
                                        {
                                            $q->where('store_id',$storeId);
                                        });
                                    })
                                    ->when($distributorId, function($query, $distributorId)
                                    {
                                        return $query->whereHas('distributors',function ($query) use($distributorId){
                                            $query->where('distributor_id',$distributorId);
                                        });
                                    })
                                    ->when($userId, function($query, $userId)
                                    {
                                        return $query->whereHas('user',function($q) use ($userId)
                                        {
                                            $q->where('id',$userId);
                                        });
                                    })->value("total") ?? 0;
                                   
        return $orderData;
    }

    
}
