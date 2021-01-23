<?php
namespace App\Modules\Store\Models;

use App\Models\Distributor;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_uid',
        'user_id',
        'delivery_address',
        'cart_subtotal',
        'promo_code',
        'additional_charges',
        'discounts',
        'net_amount',
        'payment_method',
        'is_scheduled',
        'schedule_date',
        'order_data',
        'order_status',
        'store_id'
    ];

    protected $appends = [
        'format_created_at'
    ];

    public function getFormatCreatedAtAttribute()
    {
        return date('d M Y , h:i A', strtotime($this->created_at));
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function drivers()
    {
        return $this->hasOne(DistributorOrder::class, 'order_id', 'id');
    }

    public function distributors()
    {
        return $this->belongsToMany(Distributor::class)->withPivot('schedule_date');
    }

}
