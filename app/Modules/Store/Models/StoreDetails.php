<?php


namespace App\Modules\Store\Models;


use App\Store;
use Illuminate\Database\Eloquent\Model;

class StoreDetails extends Model
{
    protected $table = "store_details";

    protected $fillable = [
        'store_name','contact_number','formatted_address',
        'store_id','about_store','lat','lng','banner_image_url'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function store_images()
    {
        return $this->hasManyThrough(StoreImages::class, Store::class, 'id', 'store_id', 'store_id')->select(['file_url']);
    }

}
