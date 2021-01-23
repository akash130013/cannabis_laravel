<?php

namespace App\Http\Controllers\Api\Distributor;

use App\Helpers\CommonHelper;
use App\Http\Services\DistributorService;
use App\Http\Services\SmsService;
use App\Models\DistributorLocation;
use App\Transformers\DistributorTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DistributorController extends Controller
{
    /**
     * @var DistributorService
     */
    protected $distributorService;

    /**
     * DistributorController constructor.
     * @param DistributorService $distributorService
     */
    public function __construct(DistributorService $distributorService)
    {
        $this->distributorService = $distributorService;
    }

    /**
     * view profile.
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        try {
            $id          = $id ?? \request()->user()->id;
            $distributor = $this->distributorService->getDistributors(['id' => $id])->first();
            if (!$distributor) {
                return response()->jsend_error(new \Exception(config('constants.NotFound')), $message = null);
            }

            $distributor = DistributorTransformer::TransformObject($distributor);
            return response()->jsend($data = $distributor, $presenter = null, $status = "success", $message = "show profile", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * update distributor profile
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function update(Request $request, $id = null)
    {
        try {
            $distributorId = $id ?? \request()->user()->id;
            $status        = $this->distributorService->updateDistributor($distributorId, $request->all());
            if (!$status) {
                return response()->jsend_error(new \Exception(config('constants.UpdationFailed')), $message = null);
            }
            $distributor = $this->distributorService->getDistributors(['id' => $distributorId])->first();
            $distributor = DistributorTransformer::TransformObject($distributor);
            return response()->jsend($data = $distributor, $presenter = null, $status = "success", $message = "update profile", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }

    /**
     * distributot change password.
     * @param Request $request
     * @return mixed
     */
    public function changePassword(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'old_password' => 'required',
                'password'     => ['required', 'min:6']
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $distributor = $this->distributorService->distributor->find($request->user()->id);
            if (!Hash::check($request->old_password, $distributor->password)) {
                return response()->jsend_error(new \Exception("Old password does not match"), $message = null, $code = 422);
            }
            $distributor->password = Hash::make($request->password);
            if ($distributor->save())
                return response()->jsend($data = $distributor, $presenter = null, $status = "success", $message = "password has been changed", $code = 200);


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
    public function sendOTPDistributor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => 'required',
                'phone_number' => ['required', 'numeric', 'unique:distributors', function ($attribute, $value, $fail) {
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
    public function verifyOTPDistributor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => 'required',
                'phone_number' => 'required|unique:distributors,phone_number,"","",deleted_at,NULL',
                "otp"          => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            if ($request->has('phone_number')) {
                $smsService = new SmsService;
                $status     = $smsService->verifyOtp($request->all(['country_code', 'phone_number', 'otp']));
                $param      = ['country_code' => $request->country_code, 'phone_number' => $request->phone_number];
            }
            if (!$status) {
                return response()->jsend_error(new \Exception('OTP mismatch'), $message = null, $code = 406);
            }
            $distributor               = $request->user();
            $distributor->country_code = $request->country_code;
            $distributor->phone_number = $request->phone_number;
            if ($distributor->save()) {
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
     * update driver location
     * @param Request $request
     * @return mixed
     */
    public function updateLocation(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'longitude' => 'required',
                'latitude'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $request->request->add(['id' => $request->user()->id]);
            $result = $this->distributorService->updateDistributorLocation($request->all());
            if (!$result) {
                throw new \Exception('unable to save location');
            }
            return response()->jsend($data = $result, $presenter = null, $status = "success", $message = "location updated", $code = config('constants.SuccessCode'));

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
            $workStatus = 'offline';
            $status     = $this->distributorService->updateDistributorStatus($workStatus);
            if (!$status) {
                throw new \Exception("driver status updation failed");
            }
            $request->user()->token()->revoke();
            $request->user()->tokens()->each(function ($token) {
                $token->delete(); // My Token
            });
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "status updated to " . $workStatus, $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }


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
                'user_type'    => config('constants.userType.driver'),
                'device_token' => $request->device_token,
                'device_type'  => $request->device_type,
            ];
            $status = $this->smsService->saveDeviceToken($saveDeviceToken);
            if (!$status) {
                return response()->jsend_error(new \Exception("device token not updated"), $message = null);
            }
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Device token has been updated", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            return CommonHelper::catchException($exception);
        }

    }
}
