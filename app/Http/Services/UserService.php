<?php


namespace App\Http\Services;

use App\Helpers\CommonHelper;
use App\Models\LoggedToken;
use App\Models\LoyaltyPointTransaction;
use App\Models\PhoneReset;
use App\Models\UserReset;
use App\Modules\User\Models\UserDetail;
use App\Modules\User\Models\UserProof;
use App\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserService
 * @package App\Http\Services
 * @author Sumit Sharma
 */
class UserService
{
    /**
     * @var User
     */
    public $user;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->user->updateOrCreate([
            'country_code' => $data['country_code'],
            'phone_number' => $data['phone_number']
        ], [
            'dob'         => $data['dob'],
            'email'       => $data['email'] ?? '',
            'name'        => $data['name'],
            'password'    => $data['password'],
            'referred_by' => $data['referred_by'] ?? null
        ]);
    }

    /**
     * @param $user
     * @return mixed
     */
    public function generateUserToken($user)
    {
        $user->accessToken = $user->createToken(trans('Cannabies.AppName'))->accessToken;
        return $user;
    }

    /**
     * @param $param
     * @return \Illuminate\Support\Collection
     */
    public function getUser($param)
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $users = $this->user->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['name']), function ($q) use ($param) {
                return $q->where('name', 'LIKE', $param['name']);
            })
            ->when(isset($param['status']), function ($q) use ($param) {
                return $q->where('status', $param['status']);
            })
            ->when(isset($param['user_referral_code']), function ($q) use ($param) {
                return $q->where('user_referral_code', $param['user_referral_code']);
            })
            ->when((isset($param['country_code']) && isset($param['phone_number'])), function ($q) use ($param) {
                return $q->where(['country_code' => $param['country_code'], 'phone_number' => $param['phone_number']]);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $users = CommonHelper::restPagination($users->paginate($param['pagesize']));
            } else {
                $users = $users->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $users = $users->get();
        }

        return $users;
    }

    /**
     * @param $userId
     * @return array
     */
    public function userResetToken($userId)
    {
        $userData = [
            'user_id'     => $userId,
            'reset_token' => Str::uuid(),
        ];

        UserReset::where('user_id', $userId)->delete();
        UserReset::Create($userData);
        return $userData;
    }

    /**
     * @param $userId
     * @param $resetToken
     * @param $password
     * @return bool
     */
    public function resetPassword($userId, $resetToken, $password)
    {
        $userReset = UserReset::where(['user_id' => $userId, 'reset_token' => $resetToken])->first();
        if ($userReset) {
            $userReset->delete();
            $user           = $this->user->find($userId);
            $user->password = Hash::make($password);
            $user->save();
            return true;
        }

        return false;
    }

    /**
     * @param $user
     * @return void
     */
    public function generateUserReferralCode($user)
    {
        $userReferralCode         = Str::random(5);
        $user->user_referral_code = strtoupper($userReferralCode) . $user->id;
        $user->save();
        return $user;
    }

    /**
     * @param $userId
     * @return array
     */
    public function phoneResetToken($data)
    {
        $userData = [
            'country_code' => $data['country_code'],
            'phone_number' => $data['phone_number'],
            'reset_token'  => Str::uuid(),
        ];

        PhoneReset::where(['country_code' => $data['country_code'], 'phone_number' => $data['phone_number']])->delete();
        PhoneReset::Create($userData);
        return $userData;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function changePhoneNumber(array $data)
    {
        $phoneReset = PhoneReset::where(['reset_token' => $data['reset_token']])->first();
        if ($phoneReset) {
            $phoneReset->delete();
            $user               = $this->user->find($data['userId']);
            $user->country_code = $data['country_code'];
            $user->phone_number = $data['phone_number'];
            $user->save();
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function updateUser($id, array $data)
    {
        $user       = $this->user->find($id);
        $user->name = $data['name'];
        $user->dob  = $data['dob'];
        if ($user->email !== $data['email']) {
            $user->email             = $data['email'];
            $user->email_verified_at = null;
        }
        if (Arr::has($data, 'profile_pic')) {
            $user->profile_pic = $data['profile_pic'];
        }

        if (!$user->save()) {
            return false;
        }

        if (Arr::has($data, 'age_proof')) {
            UserProof::updateOrCreate(['user_id' => $user->id, 'type' => 1], ['file_url' => $data['age_proof'], 'file_name' => basename($data['age_proof'])]);
        }
        if (Arr::has($data, 'medical_proof')) {
            if (is_null($data['medical_proof'])) {
                UserProof::where(['user_id' => $user->id, 'type' => 2])->delete();
            } else {
                UserProof::updateOrCreate(['user_id' => $user->id, 'type' => 2], ['file_url' => $data['medical_proof'], 'file_name' => basename($data['medical_proof'])]);
            }
        }

        return true;
    }

    /**
     * get user loyaltyPointsTransactions
     * @param $param
     * @return \Illuminate\Support\Collection
     */
    public function userLoyaltyPoints($param)
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $loyaltyPoints = LoyaltyPointTransaction::select($selectColumn)
            ->when(isset($param['user_id']), function ($q) use ($param) {
                $q->where('user_id', $param['user_id']);
            })
            ->when(isset($param['orderBy']), function ($q) use ($param) {
                $q->orderBy('id', $param['orderBy']);
            });


        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $loyaltyPoints = CommonHelper::restPagination($loyaltyPoints->paginate($param['pagesize']));
            } else {
                $loyaltyPoints = $loyaltyPoints->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $loyaltyPoints = $loyaltyPoints->get();
        }

        return $loyaltyPoints;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function generateLoginToken(array $data)
    {
        LoggedToken::where('user_id', $data['user_id'])->delete();
        $data['login_token'] = Str::uuid();
        return LoggedToken::create($data);
    }

    /**
     * @param $user
     * @param array $data
     * @return mixed
     */
    public function updateLocation($user, array $data)
    {

        // $userDetailData = [
        //     'lat'                   => $data['latitude'],
        //     'lng'                   => $data['longitude'],
        //     'formatted_address'     => $data['address'],
        // ];

        $user->lat                 = $data['latitude'];
        $user->lng                 = $data['longitude'];
        $user->location_updated_at = now();

        try {
            UserDetail::updateOrCreate(['user_id' => $user->id], [
                'lat'                   => $data['latitude'],
                'lng'                   => $data['longitude'],
                'formatted_address'     => $data['address'],
            ]);
        } catch (Exception $e) {
            info($e);
        }

        return $user->save();
    }

    /**
     * @desc delete token
     */
    public function getUserfromLoginToken($token)
    {
        
        $isDelete = $token = LoggedToken::where(['login_token' => $token])->first();
        if ($isDelete) {
            $isDelete->delete();
        }

        return $token;
    }
}
