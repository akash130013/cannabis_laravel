<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    protected $casts = [
        'order_json' => 'array',
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'carts',  'id', 'product_id');
    }

    public function storeDetail()
    {
        return $this->hasMany(StoreDetail::class, 'store_id', 'store_id');
    }

    public function order()
    {
//        return $this->belongsToMany(Order::class, 'order_uid', 'order_uid');
        return $this->belongsTo(Order::class, 'order_uid', 'order_uid');
    }
}
