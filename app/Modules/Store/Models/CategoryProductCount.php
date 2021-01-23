<?php


namespace App\Modules\Store\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CategoryProductCount extends Model
{
    protected $table = "category_product_count";

    const ACTIVE_PRODUCTS = 'active';

    protected $fillable = [
    'product_id', 'store_id','product_count',
  ];


}