<?php

namespace App\Models;

use App\Store;
use Illuminate\Database\Eloquent\Model;

class StoreNotifications extends Model
{
    protected $table = "store_notifications";

    protected $fillable = [
        'title',
        'store_id',
        'description',
        'type',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array'
    ];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
