<?php

namespace App\Models;

use App\Modules\Store\Models\StoreImages;
use App\Store;
use Illuminate\Database\Eloquent\Model;

class StoreDetail extends Model
{
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function store_images()
    {
        return $this->hasManyThrough(StoreImages::class, Store::class, 'id', 'store_id')->select(['file_url']);
    }


}
