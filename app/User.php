<?php

namespace App;

use App\Models\LoyaltyPointTransaction;
use App\Models\Order;
use App\Models\UserPromoCode;
use App\Modules\User\Models\UserDetail;
use App\Modules\User\Models\UserProof;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use DB;
use App\Notifications\UserResetPasswordNotification;
class User extends Authenticatable
{
    use HasMultiAuthApiTokens, Notifiable;

    /**
     * The function is to use soft delete of data
     */

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'dob', 'country_code', 'phone_number', 'email', 'profile_pic', 'password', 'personal_address','lat','lng','referred_by','is_proof_completed','location_updated_at','status','user_referral_code','email_verified_token', 'push_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'phone_number_verified_at', 'email_verified_at', 'referral_code', 'first_name', 'last_name', 'email_verified_token'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function userProof()
    {
        return $this->hasMany(UserProof::class);
    }

    public function getuser()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function orders()
    {
       return $this->hasMany(Order::class,'user_id','id')->whereNotIn('order_status',['init','checkout']);
    }

    /**
     * This function is used for relationship between promocode and user
     *
     */
     public function redeemedPromoCode()
     {
         return $this->hasMany(UserPromoCode::class);
     }

    /**
     * fetch loyalty_points
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPointTransaction::class, 'user_id', 'id');
    }

     /*
     * Column Position in data table
     */
    protected static $userTableDataSort = [
        1 => "users.id",
        23 => "users.created_at",


    ];

      /**
     * To fetch user data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getUserData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
        $orderColumn = self::$userTableDataSort[$orderBy['column']];
        $list = User::select('id','name','email','phone_number','dob','status','created_at','profile_pic','is_profile_complete')
            ->where('is_profile_complete',true)
            ->where(function ($query) use ($filter, $searchLike) {
                $query->when($searchLike,
                    function ($query, $searchLike) {
                        $query->Where('name', 'like', '%' . $searchLike . '%')
                            ->orWhere('email', 'like','%'. $searchLike . '%')
                            ->orWhere('phone_number', 'like','%'. $searchLike . '%');
                    });
            })
            ->when($filter['promoCode'],function($query,$promoCode)
            {
                $query->whereHas('redeemedPromoCode',function($q) use($promoCode)
                {
                    $q->where('promo_code',$promoCode);
                });
            })
            ->when($filter['status'], function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($filter['endDate'], function ($query, $endDate) {
                return $query->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
            })
            ->when($filter['startDate'], function ($query, $startDate) {
                return $query->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
            })
            ->when($filter['endDOB'], function ($query, $endDOB) {
                return $query->where('dob', '<=', $endDOB . config('constants.DATE.END_DATE_TIME'));
            })
            ->when($filter['startDOB'], function ($query, $startDOB) {
                return $query->where('dob', '>=', $startDOB . config('constants.DATE.START_DATE_TIME'));
            });
            $userData['filteredCount'] = $list->count();

            $userData['data'] = $list->orderBy($orderColumn, $orderBy['dir'])
                                    ->offset($offset)
                                    ->limit($limit)
                                    ->get();
        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $userData['totalCount'] = User::selectRaw($totalCountFields)->where('is_profile_complete',true)->value("total") ?? 0;
        return $userData;
    }




}
