<?php


namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DistributorProof extends Model
{
    protected $fillable = [
        'distributor_id',
        'type',
        'file_url',
        'is_validated',
        'proof_type'
    ];
}
