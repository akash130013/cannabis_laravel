<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Services\DeliveryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class DeliveryController
 * @package App\Http\Controllers\Api\User
 * @author Sumit Sharma
 */
class DeliveryController extends Controller
{
    /**
     * @var deliveryService
     */
    protected $deliveryService;

    /**
     * DeliveryController constructor.
     * @param DeliveryService $deliveryService
     */
    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * get address of an user
     * @param null $userId
     * @return mixed
     */
    public function showAddress($userId = null)
    {
        try {
            $user_id   = $userId ?? \request()->user()->id;
            $validator = \Validator::make(['user_id' => $user_id], [
                'user_id' => 'exists:users,id',
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $addresses = $this->deliveryService->getUserDeliverAddress(['user_id' => $user_id]);
            return response()->jsend($data = $addresses, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * save delivery address.
     * @param Request $request
     * @return mixed
     */
    public function saveAddress(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'name'     => 'required',
                'mobile'   => 'required',
                'address'  => 'required',
                "locality" => "required",
                "city"     => "required",
                "state"    => "required",
                "zipcode"  => "required",
                "country"  => "required",
                "lat"      => "required",
                "lng"      => "required",
                "address_type" => ["sometimes", Rule::in(['Home', 'Office', 'Other'])],
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }


            $request->request->add(['user_id' => $request->user()->id]);
            $request->request->add(['formatted_address' => $request->name . ', ' . $request->address . ' ' . $request->locality . ' ' . $request->city . ', ' . $request->state . ', ' . $request->zipcode . ' ' . $request->country]);

//            $formattedAddress = $request->except('id');
//            $request->request->add(['formatted_address' => $formattedAddress]);

            $address = $this->deliveryService->saveAddress($request->all());
            return response()->jsend($data = $address, $presenter = null, $status = "success", $message = null, $code = config('constants.SuccessCode'));

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
    public function updateAddress(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'id'       => ['required', Rule::exists('user_delivery_location')->where(function ($query) {
                    $query->where(['id' => \request()->id, 'user_id' => request()->user()->id]);
                })],
                'name'     => 'required',
                'mobile'   => 'required',
                'address'  => 'required',
                'locality' => 'required',
                'city'     => 'required',
                'state'    => 'required',
                'zipcode'  => 'required',
                'country'  => 'required',
                'lat'      => 'required',
                'lng'      => 'required',
                "address_type" => ["sometimes", Rule::in(['Home', 'Office', 'Other'])],
            ], [
                'id.exists' => 'Id is not associate with current user'
            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $request->request->add(['user_id' => $request->user()->id]);
            $request->request->add(['formatted_address' => $request->name . ', ' . $request->address . ' ' . $request->locality . ' ' . $request->city . ', ' . $request->state . ', ' . $request->zipcode . ' ' . $request->country]);

            $status = $this->deliveryService->updateAddress(['id' => $request->id], $request->except(['id', 'created_at', 'updated_at']));
            if (!$status) {
                return response()->jsend_error(new \Exception("Address could not be updated"), $message = null);
            }
            $address = $this->deliveryService->getUserDeliverAddress(['id' => $request->id])->first();
            return response()->jsend($data = $address, $presenter = null, $status = "success", $message = "Address Updated Successfully", $code = config('constants.SuccessCode'));

        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

    /**
     * delete user delivery address.
     * @param $id
     * @return mixed
     */
    public function destroyAddress($id)
    {
        try {
            $validator = \Validator::make(['id' => $id], [
                'id' => ['required', Rule::exists('user_delivery_location')->where(function ($query) {
                    $query->where(['id' => \request()->id, 'user_id' => request()->user()->id]);
                })],
            ]);

            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }
            $delete = $this->deliveryService->deleteAddress(['id' => $id]);
            if (!$delete) {
                return response()->jsend_error(new \Exception("Delivery Address could not be deleted"), $message = null);
            }
            return response()->jsend($data = null, $presenter = null, $status = "success", $message = "Delivery Address Deleted Successfully", $code = config('constants.SuccessCode'));
        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }

}
