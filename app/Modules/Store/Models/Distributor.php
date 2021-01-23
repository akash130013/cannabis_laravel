<?php


namespace App\Modules\Store\Models;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class Distributor extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'gender',
        'country_code',
        'phone_number',
        'phone_number_verified_at',
        'password',
        'remember_token',
        'email',
        'profile_image',
        'address',
        'city',
        'state',
        'zipcode',
        'latitude',
        'longitude',
        'dl_number',
        'dl_expiraion_date',
        'vehicle_number',
        'vehicle_images',
        'status'
    ];

    protected $appends = [
        'format_location'
    ];

    public function getFormatLocationAttribute()
    {
        return $this->address.', '.$this->city.', '.$this->state.', '.$this->zipcode;
    }

    public function proofs()
    {
        return $this->hasMany(DistributorProof::class, 'distributor_id', 'id');
    }

    public function getVehicleImage()
    {
       if(!empty($this->proofs()))
        {
            return $this->proofs()->where('type','other');
        }
        return [];
    }

    public function store()
    {
        return $this->hasOne(DistributorStore::class, 'distributor_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(DistributorOrder::class, 'distributor_id', 'id');
    }

  

    

     /**
     * get all review of distributors
     */
    public function driverReview()
    {
        
        return $this->hasMany(Rating::class, 'rated_id', 'id')->where('type','driver');
    }
    // public function setDlExpiraionDateAttribute($value)
    // {
    //     return $this->dl_expiraion_date = $value ? date('Y/m/d', strtotime($value)):$value;
    // }
}
