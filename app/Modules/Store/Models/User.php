<?php


namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email'
    ];

    public function proofs()
    {
        # code...
        return $this->hasMany(UserProof::class, 'user_id', 'id');
    }
}
