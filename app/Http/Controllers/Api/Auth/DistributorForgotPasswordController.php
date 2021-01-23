<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Services\DistributorService;
use App\Http\Services\SmsService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;

class DistributorForgotPasswordController extends Controller
{
    /**
     * @var DistributorService
     */
    protected $distributorService;
    /**
     * @var SmsService
     */
    protected $smsService;

    /**
     * DistributorForgotPasswordController constructor.
     * @param DistributorService $distributorService
     * @param SmsService $smsService
     */
    public function __construct(DistributorService $distributorService, SmsService $smsService)
    {
        $this->distributorService = $distributorService;
        $this->smsService         = $smsService;
    }

    public function sendOTP(Request $request, SmsService $smsService)
    {

        try {
            $validator = Validator::make($request->all(), [
                'country_code' => 'required',
                'phone_number' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $user = $this->distributorService->distributor->where(['country_code' => $request->country_code, 'phone_number' => $request->phone_number])->first();
            if (!$user) {
                return response()->jsend_error(new \Exception('Phone number is not registered with any user'), $message = null, $code = 406);

            }
            $ms = $this->smsService->sendSms($request->all(['country_code', 'phone_number']));
            if (is_array($ms) && isset($ms['error']) && $ms['error'] == true) {
                $msg = config('constants.INVALID_MOBILE_NUMBER');
                return response()->jsend_error(new \Exception('Invalid mobile number'), $message = $msg,422);
            } 

            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "OTP has been sent ", $code = config('constants.SuccessCode'));

        } catch (\Exception $e) {
            return $e->getMessage() . ' on ' . $e->getFile() . ' at ' . $e->getLine();
            return response()->jsend_error(new \Exception('OTP not verified'), $message = null, $code = 200);
        }
    }

    /**
     * verify OTP
     * @param Request $request
     * @return mixed
     */
    public function verifyOtp(Request $request)
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
                $status = $this->smsService->verifyOtp($request->all(['country_code', 'phone_number', 'otp']));
                $param  = ['country_code' => $request->country_code, 'phone_number' => $request->phone_number];

                if (!$status) {
                    return response()->jsend_error(new \Exception('OTP mismatch'), $message = null, $code = 406);
                }

            }


            $distributor = $this->distributorService->getDistributors($param)->first();
            if (!$distributor) {
                return response()->jsend_error(new \Exception('Phone number is not assigned to any user'), $message = null, $code = 200);

            }

            $distributorToken = $this->distributorService->generateDistributorResetToken($distributor->id);

            return response()->jsend($data = $distributorToken, $presenter = null, $status = "success", $message = "OTP verified", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);

            return response()->jsend_error(new \Exception($error['message']), $message = null, $code = $exception->getCode());
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'distributor_id' => 'required',
                'reset_token'    => 'required',
                "password"       => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $resetPasswordStatus = $this->distributorService->resetPassword($request->distributor_id, $request->reset_token, $request->password);
            if (!$resetPasswordStatus) {
                throw new \Exception('password not reset', 406);
            }
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Password reset successfully", $code = config('constants.SuccessCode'));

        } catch (\Exception $e) {
            return response()->jsend_error(new \Exception($e->getMessage()), $message = null, $code = $e->getCode());

        }

    }


}
