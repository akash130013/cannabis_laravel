<?php

namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTiming extends Model
{
    protected $table = "store_timing";

    protected $fillable = [
        'store_id',
        'day',
        'start_time',
        'end_time',
        'working_status'
    ];

    

    

}
