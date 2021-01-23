<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = "user_details";

    protected $fillable = [
        'address',
        'formatted_address',
        'city',
        'state',
        'zipcode',
        'country',
        'lat',
        'lng',
        'ip',
        'user_id',
    ];


}
