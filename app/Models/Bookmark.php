<?php

namespace App\Models;

use App\Store;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];


    public function store()
    {
        return $this->belongsToMany(Store::class) ;
    }

}
