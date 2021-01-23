<?php

namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProofs extends Model
{
    protected $table = "store_proofs";

    protected $fillable = [
        'fileurl',
        'store_id',
        'status'
    ];


}
