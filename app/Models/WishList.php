<?php

namespace App\Models;

use App\Modules\Admin\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $fillable = [
        'product_id',
        'user_id'
    ];

    protected $table = "wishlists";

    public function product()
    {
        return $this->hasOne(CategoryProduct::class, 'id', 'product_id');
    }
}
