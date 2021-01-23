<?php

namespace App\Modules\Store\Models;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class DistributorStore extends Model
{
    protected $table = 'distributor_store';

    protected $fillable = [
        'distributor_id',
        'store_id',
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id', 'id');
    }

    public function orders()
    {
        return $this->belongsTo(DistributorOrder::class, 'distributor_id', 'id');
    }
    // driver assigned orderes
    public function assginedOrders()
    {
        
        return $this->belongsTo(DistributorOrder::class, 'distributor_id', 'distributor_id');
    }

    public static function getStoreDriverList($storId, $request ,$status)
    {

        $result =  DistributorStore::with(['distributor'=>function($q){
                        $q->withCount(['driverReview'=>function($q){
                            $q->whereNotNull('review');
                        }]);
                        $q->with(['driverReview'=>function($q){
                            $q->pluck('rate');
                        }]);
                        
                    }])

                    ->when($request->keyword, function ($q) use ($request) {
                        $q->whereHas('distributor',function($w) use($request){
                            $w->where('name', 'LIKE', "%$request->keyword%");
                        });
                    })
                    ->where('store_id', $storId)
                    ->whereHas('distributor',function($query) use ($status)
                    {
                        if($status != 'all')
                        {
                            $query->when($status, function($q, $status)
                            {
                                $q->where('current_status',$status);
                            });
                        }
                        
                       
                    })
                    ->orderBy('created_at', 'desc')
                    ->Paginate(config('constants.PAGINATE'));

        return $result;
    }


    public static function getStoreDriverViewList($storId, $request)
    {

        return  DistributorStore::with(['distributor'])

        ->when($request->keyword, function ($q) use ($request) {
            $q->whereHas('distributor',function($w) use($request){
                $w->where('name', 'LIKE', "%$request->keyword%");
            });
        })
        ->where('store_id', $storId)
        ->whereHas('distributor')
        ->orderBy('created_at', 'desc')
        ->get();
    }



    public static function getAllocatedDriverList($storId, $request, $excludedDistributorId = [])
    {

        return DistributorStore::withCount(['assginedOrders' => function($query)
        {
            $query->wherehas('orderDetail',function($q)
            {
                $q->whereNotIn('order_status',['delivered','order_cancelled','amount_refund_init','amount_refunded','amount_received']
            );
            });
        }])
        ->when($request->keyword, function ($q) use ($request) {
            $q->whereHas('distributor',function($v) use ($request){
                $v->where('name', 'LIKE', "%$request->keyword%");

            });
        })->when(isset($excludedDistributorId), function ($query)use ($excludedDistributorId){
                $query->whereNotIn('distributor_id', $excludedDistributorId);
            })

        // ->withCount(['distributor.orders'])

        ->whereHas('distributor', function ($query) {

            $query->where('status', '!=', config('constants.STATUS.BLOCKED'));
        })

        ->where('store_id', $storId)

        ->orderBy('created_at', 'desc')

        ->simplePaginate(config('constants.PAGINATE'));
    }
}
