<?php

namespace App\Models;

use App\Modules\Admin\Models\CategoryProductImages;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 * @author Sumit Sharma
 */
class Product extends Model
{
    protected $table = "category_products";

    protected $casts = [
        'quantity_json' => 'array',
    ];

    /**
     * relation with category model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function product_images()
    {
        return $this->hasMany(CategoryProductImages::class, 'product_id', 'id');
    }

}
