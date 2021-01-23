<?php


namespace App\Modules\Store\Models;


use Illuminate\Database\Eloquent\Model;

class StoreImages extends Model
{
    protected $table = "store_images";

    protected $fillable = [
        'store_id','file_url'
    ];

    
}