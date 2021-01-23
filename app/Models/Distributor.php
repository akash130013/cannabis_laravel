<?php

namespace App\Models;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Distributor extends Authenticatable
{
    use HasMultiAuthApiTokens, Notifiable;
     /**
     * The function is to use soft delete of data
     */

    use SoftDeletes;
    /**
     * guard is being used for authentication.
     * @var @guard
     */

    protected $guard = 'distributor';
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'password',
    ];

    /**
     * json column
     * @var array
     */
    protected $casts = [
      'vehicle_images' => 'array',
    ];

    public function proofs()
    {
        return $this->hasMany(DistributorProof::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('schedule_date');
    }

    public function getVehicleImage()
    {
        if(!empty($this->proofs()))
        {
            return $this->proofs()->where('type','other');
        }
        return [];
    }


    public function completedOrders()
    {
        if($this->orders()->exists())
        {
           return $this->orders()->where('order_status','delivered');
        }
        return null;
    }

    /**
     * get distributors completed orders total count
     */
    // public function totalCompletedOrders()
    // {
    //     $orders = $this->orders;
    //     $count = 0;
    //     if($orders)
    //     {
    //         $count = $orders->whereIn('status',['delivered', 'amount_received'])->count();
    //     }
    //   return $count
    // }

    /**
     * get all stores for distributors
     */
    public function stores()
    {
        return $this->belongsToMany('App\Store', 'distributor_store', 'distributor_id', 'store_id');
    }




    public function locations()
    {
        return $this->hasMany(DistributorLocation::class);
    }

    // /**
    //  * @param s
    //  */
    // public function scopeWithStoreDetail($query, $programId)
    // {
    //     return   $query->whereHas('programs', function ($q) use ($programId) {
    //         $q->whereId($programId);
    //     });
    // }

     /*
     * Column Position in data table
     */
    protected static $tableDataSort = [
        1 => "distributors.name",


    ];

      /**
     * To fetch distributor data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getdistributorData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter, $storeId)
    {
        // $selectFields = " SQL_CALC_FOUND_ROWS
        // distributors.id,
        // distributors.name,
        // distributors.email,
        // distributors.phone_number,
        // distributors.created_at,
        // distributors.status";

         $orderColumn = self::$tableDataSort[$orderBy['column']];
         $storeId      = $storeId !=null? (int) $storeId:null;
        // info([$storeId,$searchLike, $filter]);

       $list =  Distributor::select('id','name','email','phone_number','created_at','admin_status')
                                    ->when($searchLike, function($query) use($searchLike)
                                    {
                                        $query->where('name', 'like', '%' . $searchLike . '%')
                                            ->orWhere('email', 'like', '%' . $searchLike . '%')
                                            ->orWhere('phone_number', 'like', '%' . $searchLike . '%');

                                    })
                                    ->when($storeId, function($query, $storeId)
                                    {
                                        return $query->whereHas('stores',function($q) use ($storeId)
                                        {
                                            $q->where('store_id',$storeId);
                                        });
                                    })
                                    ->when($filter['endDate'], function ($query, $endDate) {
                                        return $query->where('distributors.created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                                    })
                                    ->when($filter['startDate'], function ($query, $startDate) {
                                        return $query->where('distributors.created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                                    })
                                    ->when($filter['status'], function ($query, $status) {
                                        return $query->where('admin_status', $status);
                                    })
                                    ->orderBy($orderColumn, $orderBy['dir']);
        $distributorData['filteredCount'] = $list->count();

        $distributorData['data'] = $list->limit($limit)
        ->offset($offset)
        ->get();


        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $distributorData['totalCount'] = Distributor::selectRaw($totalCountFields)->value("total") ?? 0;
        $distributorData['data']->load('stores.storeDetail');
        return $distributorData;
    }






}
