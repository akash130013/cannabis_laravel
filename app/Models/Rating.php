<?php

namespace App\Models;

use App\Events\OrderRatedEvent;
use App\Modules\Admin\Models\CategoryProduct;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(CategoryProduct::class, 'rated_id')->where('type', 'product');
    }


    /**
     * @param $query
     * @param $productStockId
     * @return mixed
     */
    public function scopeWithProduct($query, $productStockId)
    {
        return $query->whereHas('product', function ($q) use ($productStockId) {
            $q->withProduct($productStockId);
        });
    }
}
