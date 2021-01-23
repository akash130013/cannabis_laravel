<?php


namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;

class UserProof extends Model
{
    protected $fillable = [
        'type',
        'file_url',
        'file_name',
        'status',
        'user_id'
    ];

    public function proofs()
    {
        return $this->hasMany(UserProof::class, 'user_id', 'id');
    }
}
