<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\CommonHelper;
use App\Http\Services\DistributorService;
use App\Http\Services\SmsService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth
 * @author Sumit Sharma
 */
class DistributorLoginController extends Controller
{
    /**
     * @var DistributorService
     * @var SmsService
     */
    protected $distributorService, $smsService;

    /**
     * LoginController constructor.
     * @param DistributorService $distributorService
     * @param SmsService $smsService
     */
    public function __construct(DistributorService $distributorService, SmsService $smsService)
    {
        $this->distributorService = $distributorService;
        $this->smsService         = $smsService;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'country_code' => ['required'],
            'phone_number' => ['required', Rule::exists('distributors')->where(function ($query) {
                $query->where(['country_code' => \request()->country_code, 'phone_number' => request()->phone_number]);
            })],
            'password'     => ['required'],
            'device_token' => ['sometimes'],
            'device_type'  => ['required_with:device_token', Rule::in(config('constants.DEVICE_TYPE'))],
        ], [
            'phone_number.exists' => 'Phone number does not exists'
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
            $distributor = $this->distributorService->distributor->where('country_code', $request->country_code)->where('phone_number', $request->phone_number)->first();
            if (!$distributor) {
                return response()->jsend_error(new \Exception("Phone number does not exists"), $message = null, $code = 422);
            }


            if (!Hash::check($request->password, $distributor->password)) {
                return response()->jsend_error(new \Exception(config('constants.INVALID_CREDENTIALS_MSG')), $message = null, $code = 422);

            }
            if (is_null($distributor->phone_number_verified_at)) {
                return response()->jsend_error(new \Exception("phone number not verified"), $message = null, $code = 410);
            }

            if ($distributor->status == config('constants.STATUS.BLOCKED')) {
                return response()->jsend_error(new \Exception("Your account has been blocked"), $message = null, $code = 410);
            }
            $distributor = $this->distributorService->generateAccessToken($distributor);
            

            $distributor->rating = CommonHelper::fetchAvgRating($distributor->id, 'driver');
            $this->distributorService->updateDistributorStatus('online', $distributor->id);
            $last_order                  = $this->distributorService->driverLastOrderData($distributor->id);
            $distributor->last_order     = isset($last_order->orders) ? $last_order->orders->first()->order_uid : null;
            $distributor->vehicle_images = Arr::pluck($distributor->getVehicleImage, 'file_url');
            if ($request->has('device_token') && !empty($request->device_token)) {
                $saveDeviceToken = [
                    'user_id'      => $distributor->id,
                    'user_type'    => config('constants.userType.driver'),
                    'device_token' => $request->device_token,
                    'device_type'  => $request->device_type,
                ];
                $this->smsService->saveDeviceToken($saveDeviceToken);

            }

            return response()->jsend($data = $distributor, $presenter = null, $status = "success", $message = null, $code = 200);

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on file ' . $exception->getFile() . ' at line ' . $exception->getLine();
            Log::error('User login error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }


    }

}
