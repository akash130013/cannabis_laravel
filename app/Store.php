<?php

namespace App;

/**
 * Remove 'use Illuminate\Database\Eloquent\Model;'
 */

use App\Models\StoreDetail;
use App\Models\Order;
use App\Modules\Store\Models\StoreDeliveryAddress;
use App\Models\Distributor;
use App\Models\StoreCommision;
use App\Models\StoreEarning;
use App\Modules\Store\Models\StoreImages;
use App\Modules\Store\Models\StoreProductStock;
use App\Modules\Store\Models\StoreTiming;
use App\Notifications\StoreResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Store extends Authenticatable

{
    use Notifiable;
    /**
     * The function is to use soft delete of data
     */

    use SoftDeletes;

    protected $table = "store";


    // The authentication guard for admin
    protected $guard = 'store';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'avatar', 'last_name', 'phone', 'business_name', 'is_admin_approved', 'admin_action',
        'licence_number', 'password', 'is_email_verified', 'is_mobile_verified', 'status', 'time_zone', 'updated_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StoreResetPasswordNotification($token));
    }

    public function storeDetail()
    {
        return $this->hasOne(StoreDetail::class);
    }

    public function commission()
    {
        return $this->hasOne(StoreCommision::class,'store_id','id');
    }

    public function earnings()
    {
        return $this->hasMany(StoreEarning::class,'store_id','id');
    }

    public function completedOrders()
    {
        return $this->hasMany(Order::class)->whereIn('order_status', ['delivered', 'amount_received']);
    }

    public function store_images()
    {
        return $this->belongsToMany(StoreImages::class);
    }

    public function storeImages()
    {
        return $this->hasMany('App\Modules\Store\Models\StoreImages', 'store_id', 'id');
    }

    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_store', 'store_id', 'distributor_id');
    }

    public function deliveryLocations()
    {
        return $this->hasMany(StoreDeliveryAddress::class, 'store_id', 'id');
    }

    public function storeTiming()
    {
        return $this->hasMany(StoreTiming::class, 'store_id', 'id');
    }

    public function storeProducts()
    {
        return $this->hasMany(StoreProductStock::class,'store_id','id');
    }
    public function todayStoreOpeningStatus()
    {
        $storeTiming = $this->storeTiming();
        $now         = Carbon::now($this->time_zone);
        $storeTiming = StoreTiming::where(['store_id' => $this->id, 'day' => $now->dayOfWeek])->first();
        if (!$storeTiming) {
            return 0;
        }
        if ($now->isBetween(Carbon::parse('today ' . $storeTiming->start_time, $this->time_zone), Carbon::parse('today ' . $storeTiming->end_time, $this->time_zone), true)) {
            return 1;
        }
        return 0;
    }


    /*
     * Column Position in data table
     */
    protected static $storeTableDataSort = [
        1 => "store.created_at",
    ];

    /**
     * To fetch store data list
     *
     * @param int $offset List page number
     * @param int $limit Total rows on one page
     * @param string $searchLike search string
     * @param string $orderBy order by key
     * @return Array|Bolean
     */
    public static function getStoreData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
        $orderColumn = self::$storeTableDataSort[$orderBy['column']];

        $storeData['data'] = Store::select('id', 'created_at', 'email', 'phone', 'status', 'avatar', 'is_profile_complete')
                                ->orderBy($orderColumn, $orderBy['dir'])
                                ->where('is_profile_complete', true)
                                ->where('admin_action', 'approve')
                                ->where('is_admin_approved', true)
                                ->when($filter['status'], function ($query, $status) {
                                    return $query->where('status', $status);
                                })
                                ->when($filter['productId'], function ($query, $productId) {
                                    return $query->whereHas('storeProducts', function($q) use($productId)
                                        {
                                            $q->where('product_id',$productId);
                                        });
                                })
                                ->when($filter['endDate'], function ($query, $endDate) {
                                    return $query->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                                })
                                ->when($filter['startDate'], function ($query, $startDate) {
                                    return $query->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                                });
        if (!empty($searchLike)) {
            $storeData['data'] = $storeData['data']->whereHas('storeDetail', function ($query) use ($searchLike) {
                $query->where(function ($query) use ($searchLike) {
                    $query->where('formatted_address', 'LIKE', '%' . $searchLike . '%')
                            ->orWhere('store_name', 'LIKE', '%' . $searchLike . '%')
                            ->orWhere('email', 'LIKE', '%' . $searchLike . '%')
                            ->orWhere('store_id', 'LIKE', '%' . $searchLike . '%');
                });
            });
        }
        $result                     = $storeData['data']->get();
        $storeData['filteredCount'] = Store::selectRaw("FOUND_ROWS() total")->where('is_profile_complete', true)->value("total") ?? 0;

        $storeData['data'] = $storeData['data']->offset($offset)
            ->limit($limit)
            ->get();
        $storeData['data']->load('storeDetail','commission');
        // $storeData['data']->earning()->withSum('commission');
        $totalCountFields        = " SQL_NO_CACHE count(id) total";
        $storeData['totalCount'] = Store::selectRaw($totalCountFields)
                                    ->where('is_profile_complete', true)
                                    ->when($filter['productId'], function ($query, $productId) {
                                        return $query->whereHas('storeProducts', function($q) use($productId)
                                            {
                                                $q->where('product_id',$productId);
                                            });
                                    })
                                    ->where('admin_action', 'approve')
                                    ->where('is_admin_approved', true)
                                    ->value("total") ?? 0;
        return $storeData;
    }


    /**
     * To fetch requested store data list
     *
     * @param int $offset List page number
     * @param int $limit Total rows on one page
     * @param string $searchLike search string
     * @param string $orderBy order by key
     * @return Array|Bolean
     */
    public static function getRequestedStoreData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
        $orderColumn = self::$storeTableDataSort[$orderBy['column']];

        $storeData['data'] = Store::select('id', 'admin_action', 'created_at', 'business_name', 'email', 'phone', 'status', 'avatar', 'is_profile_complete')
            ->orderBy($orderColumn, $orderBy['dir'])
            ->where('is_profile_complete', true)
            ->whereIn('admin_action', [config('constants.STATUS.PENDING'), config('constants.STATUS.REJECT')])
            ->where('is_admin_approved', false)
            ->when($searchLike, function ($q, $searchLike) {
                $q->whereHas('deliveryLocations', function ($query) use ($searchLike) {
                    $query->where(function ($query) use ($searchLike) {
                        $query->where('formatted_address', 'LIKE', '%' . $searchLike . '%');
                    });
                });
            })
            ->when($filter['status'], function ($query, $status) {
                return $query->where('admin_action', $status);
            })
            ->when($filter['endDate'], function ($query, $endDate) {
                return $query->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
            })
            ->when($filter['startDate'], function ($query, $startDate) {
                return $query->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
            });
        $result                     = $storeData['data']->get();
        $storeData['filteredCount'] = Store::selectRaw("FOUND_ROWS() total")->where('is_profile_complete', true)->value("total") ?? 0;

        $storeData['data'] = $storeData['data']->offset($offset)
            ->limit($limit)
            ->get();
        $storeData['data']->load('storeDetail', 'deliveryLocations');
        $totalCountFields        = " SQL_NO_CACHE count(id) total";
        $storeData['totalCount'] = Store::selectRaw($totalCountFields)
                                    ->where('is_profile_complete', true)
                                    ->whereIn('admin_action', [config('constants.STATUS.PENDING'), config('constants.STATUS.REJECT')])
                                    ->where('is_admin_approved', false)
                                    ->value("total") ?? 0;
        return $storeData;
    }
}
