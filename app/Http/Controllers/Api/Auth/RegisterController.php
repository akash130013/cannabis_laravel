<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\LPCreditEvent;
use App\Http\Services\SmsService;
use App\Http\Services\UserService;
use App\Notifications\UserMailVerifyNotification;
use App\Rules\AppRegisterRule;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\User\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Nullable;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Api\Auth
 * @author Sumit Sharma
 */
class RegisterController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:50'],
            'password'      => ['required', 'string', 'min:6'],
            'email'         => ['sometimes', 'nullable', 'email', 'max:255', Rule::unique('users')->where(function ($query) {
                                    return $query->whereNotNull('email_verified_at');
                                })],
            'country_code'  => ['required'],
            'phone_number'  => ['required', 'numeric', new AppRegisterRule($data['country_code']), function ($attribute, $value, $fail) {
                if (strlen($value) < 10) $fail($attribute . ' should be atleast 10 digits'); 
            }],
            'dob'           => ['required', 'before_or_equal:' . \Carbon\Carbon::now()->subYears(config('constants.legal_age'))->format('Y-m-d'),],
            'referral_code' => ['sometimes', 'nullable', 'exists:users,user_referral_code'],
        ]);

    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        try {
            $smsService = new SmsService;
            $validator  = $this->validator($request->all());
            if ($validator->fails()){
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $hashedPassword = Hash::make($request->password);
            $request->request->remove('password');
            $request->request->add(['password' => $hashedPassword]);
            if ($request->has('referral_code') && !is_null($request->referral_code)) {
                $request->request->add(['referred_by' => $request->referral_code]);
                $request->request->remove('referral_code');
                $referredUserId = $this->userService->getUser(['user_referral_code' => $request->referred_by])->first()->id;
            }
            $user = $this->userService->create($request->all());
            $user = $this->userService->generateUserReferralCode($user);
            
            $ms = $smsService->sendSms($request->all(['country_code', 'phone_number']));
            if (is_array($ms) && isset($ms['error']) && $ms['error'] == true) {
                $msg = config('constants.INVALID_MOBILE_NUMBER');
                return response()->jsend_error(new \Exception('Invalid mobile number'), $message = $msg,422);
            }
            if (isset($referredUserId)){
                event(new LPCreditEvent($referredUserId, 'referred', 'Loyalty Point credit on referral_code by ' . $user->id));
            }
            
            if ($request->email)
            {
                $time     = now()->addMinute(10);  //set validity of the url
                $token    = [
                    'email' => $user->email,
                    'time'  => $time,
                ];
                $encToken = encrypt($token);
                $user->notify(new UserMailVerifyNotification($encToken));  //send a url for the verification link
                $user->email_verified_at    = null;
                $user->email_verified_token = $encToken;
                $user->save();
            }
            return response()->jsend($data = $user, $presenter = null, $status = "success", $message = config('constants.REGISTER_SUCCESS_MSG'), $code = 200);

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage().' file '.$exception->getFile().' line '.$exception->getLine();
            Log::error('User Register error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }


    /**
     * send OTP
     * @param Request $request
     * @param SmsService $smsService
     * @return mixed
     */
    public function sendOTP(Request $request, SmsService $smsService)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => 'required',
                'phone_number' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $param = [
                'country_code' => $request->country_code,
                'phone_number' => $request->phone_number,
            ];
            $user  = $this->userService->getUser($param)->first();
            if (!$user) {
                return response()->jsend_error(new \Exception($request->country_code . " " . $request->phone_number . " is not associated with any user"), $message = null, $code = "406");
            }
            $ms = $smsService->sendSms($request->all(['country_code', 'phone_number']));
            if (is_array($ms) && isset($ms['error']) && $ms['error'] == true) {
                $msg = config('constants.INVALID_MOBILE_NUMBER');
                return response()->jsend_error(new \Exception('Invalid mobile number'), $message = $msg,422);
            }

            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "OTP has been sent", $code = 200);

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage();
            Log::error('User Register error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

    /**
     * @param Request $request
     * @param SmsService $smsService
     * @return mixed
     */
    public function verifyOTP(Request $request, SmsService $smsService)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => 'required',
                'phone_number' => 'required',
                "otp"          => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            if ($request->has('phone_number')) {
                $status = $smsService->verifyOtp($request->all(['country_code', 'phone_number', 'otp']));
                $param  = ['country_code' => $request->country_code, 'phone_number' => $request->phone_number];
            }

            if (!$status) {
                return response()->jsend_error(new \Exception('OTP mismatch'), $message = null, $code = 406);
            }


            $user                           = $this->userService->getUser($param)->first();
            $user->phone_number_verified_at = Carbon::now();
            $user->is_profile_complete = config('constants.ACTIVE');
            $user->save();

            if (!$user) {
                return response()->jsend_error(new \Exception('Phone number is not assigned to any user'), $message = null, $code = 200);

            }

            $user = $this->userService->generateUserToken($user);

            return response()->jsend($data = $user, $presenter = null, $status = "success", $message = "OTP verified", $code = config('constants.SuccessCode'));

        } catch (\Exception $e) {
            return response()->jsend_error(new \Exception('OTP mismatch'), $message = null, $code = 200);
        }

    }


}
