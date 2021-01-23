<?php


namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DistributorOrder extends Model
{
    protected $table = "distributor_order";
    protected $fillable = [
        'distributor_id',
        'order_id',
        'order_uid',
        'sub_order_uid',
        'schedule_date'
    ];

    public function orderDetail()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }


    
    public function allocatedOrder()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }


    public function totalOrder()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
