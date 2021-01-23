<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\CommonHelper;
use App\Http\Services\SmsService;
use App\Http\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\User
 * @author Sumit Sharma
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var SmsService
     */
    protected $smsService;
    /**
     * UserController constructor.
     * @param UserService $userService
     * @param SmsService $smsService
     */
    public function __construct(UserService $userService, SmsService $smsService)
    {
        $this->userService = $userService;
        $this->smsService = $smsService;
    }


    /**
     * change logged in user password
     * @param Request $request
     * @return mixed
     */
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password'     => ['required', 'min:6'],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $user = $this->userService->user->find($request->user()->id);
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->jsend_error(new \Exception("Old password does not match"), $message = null, $code = 422);
            }
            $user->password = Hash::make($request->password);
            if ($user->save())
                return response()->jsend($data = $user, $presenter = null, $status = "success", $message = null, $code = 200);

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage();
            Log::error('Password change error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function viewProfile(Request $request, $id = null)
    {
        try {
            $userId                  = $id ?? $request->user()->id;
            $user                    = $this->userService->getUser(['id' => $userId])->first();
            $user = UserTransformer::TransformObject($user);
            return response()->jsend($data = $user, $presenter = null, $status = "success", $message = null, $code = 200);
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'          => 'required',
                'dob'           => ['required'],
                'profile_pic'   => ['sometimes'],
                'email'         => ['sometimes', 'nullable',  'email'],
                'age_proof'     => ['sometimes', 'required'],
                'medical_proof' => ['sometimes']
            ]);

            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $update = $this->userService->updateUser($request->user()->id, $request->all());
            if (!$update) {
                return response()->jsend_error(new \Exception("user profile updation failed"), $message = null);

            }
            $user = $this->userService->getUser(['id' => $request->user()->id])->first();
            $user = UserTransformer::TransformObject($user);
            return response()->jsend($data = $user, $presenter = null, $status = "success", $message = null, $code = 200);

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sendOTPUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => 'required',
                'phone_number' => ['required', 'numeric', 'unique:users', function ($attribute, $value, $fail) {
                    if (strlen($value) < 10) $fail($attribute . ' should be atleast 10 digits');
                }],

            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $smsService = new SmsService;

            $smsStatus = $smsService->sendSms($request->all(['country_code', 'phone_number']));
            if (is_array($smsStatus) && isset($smsStatus['error']) && $smsStatus['error'] == true) {
                $msg = config('constants.INVALID_MOBILE_NUMBER');
                return response()->jsend_error(new \Exception('Invalid mobile number'), $message = $msg,422);
            }
            if ($smsStatus['status'] == "success") {
                return response()->jsend($data = null, $presenter = null, $status = "verification OTP has been sent. ", $message = null, $code = 200);

            }
            return response()->jsend_error(new \Exception("OTP could not been sent"), $message = null, $code = 200);

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }


    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function verifyOTPUser(Request $request)
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
                $smsService = new SmsService;

                $status = $smsService->verifyOtp($request->all(['country_code', 'phone_number', 'otp']));
                $param  = ['country_code' => $request->country_code, 'phone_number' => $request->phone_number];
            }

            if (!$status) {
                return response()->jsend_error(new \Exception('OTP mismatch'), $message = null, $code = 406);
            }

            $user               = $request->user();
            $user->country_code = $request->country_code;
            $user->phone_number = $request->phone_number;


//            $phoneResetToken = $this->userService->phoneResetToken($request->all(['country_code', 'phone_number']));
            if ($user->save()) {
                return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Phone Number changed", $code = config('constants.SuccessCode'));

            }

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);

            return response()->jsend_error(new \Exception('OTP mismatch'), $message = null, $code = 200);
        }


    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function changePhone(Request $request)
    {
        try {
            $userId    = $request->user()->id;
            $phoneData = [
                'userId'       => $userId,
                'country_code' => $request->country_code,
                'phone_number' => $request->phone_number,
                'reset_token'  => $request->reset_token,
            ];
            $status    = $this->userService->changePhoneNumber($phoneData);
            if ($status) {
                return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Phone no. has been updated", $code = config('constants.SuccessCode'));
                return response()->jsend_error(new \Exception("Invalid Token"), $message = null, $code = $error['statusCode'] ?? 200);

            }

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }
    }

    /**
     * User Loyalty Points
     * @return mixed
     */
    public function loyaltyPoints()
    {
        try {
            $user          = \request()->user();
            $param         = [
                'user_id'  => $user->id,
                'orderBy'  => 'desc',
                'pagesize' => $request->pagesize ?? config('constants.PAGINATE'),
                'api'      => true,
            ];
            $loyaltyPoints = $this->userService->userLoyaltyPoints($param);
            return response()->jsend($data = $loyaltyPoints, $presenter = null, $status = "success", $message = "Loyalty Points", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * generate login token
     * @param Request $request
     * @return mixed
     */
    public function genenerateLoginToken(Request $request)
    {
        try {
            $param = [
                'user_id' => \request()->user()->id,
            ];
            if ($request->has('product_id')) {
                $param['product_id'] = $request->product_id;
            }else if ($request->has('store_id')) {
                $param['store_id'] = $request->store_id;
            }else if ($request->has('order_uid')) {
                $param['order_uid'] = $request->order_uid;
            }

            $token = $this->userService->generateLoginToken($param);
            return response()->jsend($data = $token, $presenter = null, $status = "success", $message = "login token", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateLocation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'longitude' => 'required',
                'latitude'  => 'required',
                'address'   => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $update = $this->userService->updateLocation($request->user(), $request->all());
            if (!$update) {
                return response()->jsend_error(new \Exception("user location updation failed"), $message = null);
            }
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "user location has been updated", $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateDeviceToken(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'device_type' => ['required', Rule::in(config('constants.DEVICE_TYPE'))],
                'device_token' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $saveDeviceToken = [
                'user_id'      => $request->user()->id,
                'user_type'    => config('constants.userType.user'),
                'device_token' => $request->device_token,
                'device_type'  => $request->device_type,
            ];
            $status = $this->smsService->saveDeviceToken($saveDeviceToken);
            if (!$status) {
                return response()->jsend_error(new \Exception("device token not updated"), $message = null);
            }
            CommonHelper::subscribeUnsubscribeTopic($request->device_type, $request->device_token, config('constants.SUBSCRIPTION_OPTION.ACTIVE'));
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Device token has been updated", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            $request->user()->tokens()->each(function ($token) {
                $token->delete(); // My Token
            });
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Logout Successfully", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }
}
