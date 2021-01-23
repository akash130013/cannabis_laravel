<?php

namespace App\Models;

use App\Modules\Admin\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];


    public function categoryProducts()
    {
        return $this->belongsTo( CategoryProduct::class,'product_id','id');
    }
}
