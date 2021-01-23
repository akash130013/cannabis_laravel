<?php


namespace App\Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryProductImages extends Model
{
    protected $table = "category_product_images";
    
    protected $fillable = [
        'product_id',
        'file_url',
        'is_default'
    ];
}