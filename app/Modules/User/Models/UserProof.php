<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserProof extends Model
{
    protected $table = "user_proofs";

    protected $fillable = [
        'type',
        'file_url',
        'user_id',
        'status',
        'file_name',
    ];


}
