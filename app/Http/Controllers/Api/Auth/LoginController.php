<?php

namespace App\Http\Controllers\Api\Auth;

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
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth
 * @author Sumit Sharma
 */
class LoginController extends Controller
{
    /**
     * @var UserService
     * @var SmsService
     */
    protected $userService, $smsService;

    /**
     * LoginController constructor.
     * @param UserService $userService
     * @param SmsService $smsService
     */
    public function __construct(UserService $userService, SmsService $smsService)
    {
        $this->userService = $userService;
        $this->smsService  = $smsService;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'country_code' => ['required'],
            'phone_number' => ['required'],
            'password'     => ['required'],
            'device_token' => ['sometimes'],
            'device_type'  => ['required_with:device_token', Rule::in(config('constants.DEVICE_TYPE'))],
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        try {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            // validation end
            $user = $this->userService->user->where('country_code', $request->country_code)->where('phone_number', $request->phone_number)->first();
            if (!$user) {
                return response()->jsend_error(new \Exception("Phone number does not exists"), $message = null, $code = 422);

            }
            if (!Hash::check($request->password, $user->password)) {
                return response()->jsend_error(new \Exception(config('constants.INVALID_CREDENTIALS_MSG')), $message = null, $code = 422);

            }
            if (is_null($user->phone_number_verified_at)) {
                return response()->jsend_error(new \Exception("phone number not verified"), $message = null, $code = 410);
            }
            $loggedUser              = UserTransformer::TransformObject($user);
            $loggedUser->accessToken = $this->userService->generateUserToken($user)->accessToken;
            if ($request->has('device_token') && !empty($request->device_token)) {
                $saveDeviceToken = [
                    'user_id'      => $user->id,
                    'user_type'    => config('constants.userType.user'),
                    'device_token' => $request->device_token,
                    'device_type'  => $request->device_type,
                ];
                $this->smsService->saveDeviceToken($saveDeviceToken);
                // subscribe to topic
                CommonHelper::subscribeUnsubscribeTopic($request->device_type, $request->device_token, config('constants.SUBSCRIPTION_OPTION.ACTIVE'));

            }
            return response()->jsend($data = $loggedUser, $presenter = null, $status = "success", $message = null, $code = 200);

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }


    }

}
