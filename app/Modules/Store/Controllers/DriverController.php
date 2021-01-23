<?php

namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Store\Models\Distributor;
use App\Modules\Store\Models\DistributorProof;
use App\Modules\Store\Models\DistributorStore;
use App\Helpers\CommonHelper;
use App\Models\Rating;
use App\Models\StoreDetail;
use App\Notifications\AddDriverNotification;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{

    /**
     *@desc used to show all the list in store
     */
    public function index(Request $request)
    {
        
      
        $data = [];
        $storeId = Auth::guard('store')->user()->id;
        $status = $request->query('status')??'';
        $data['list'] = DistributorStore::getStoreDriverList($storeId, $request,$status);
        $srNo = CommonHelper::generateSerialNumber($data['list']->currentPage(),$data['list']->perPage());
        return view('Store::driver.list',['list'=>$data['list'],'srNo'=>$srNo ,'status'=>$status]);
    }


/**
     *@desc used to show all the list in store
     */
    public function driverView(Request $request)
    {
        $data = [];
        $storeId = Auth::guard('store')->user()->id;
        $data['store']=StoreDetail::where('store_id', $storeId)->select(['lat','lng'])->first();
        $data['list'] = DistributorStore::getStoreDriverViewList($storeId, $request);
       
        return view('Store::driver.bird-view',['list'=>$data['list'],'store'=>$data['store']]);
    }


    /**
     * @desc create page open
     */
    public function create()
    {
        return view('Store::driver.add');
    }

    /**
     * @desc used to save driver detail
     */
    public function store(Request $request)
    {
       
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:distributors,email,"","",deleted_at,NULL',
            'mobile_number' => 'required|unique:distributors,phone_number,"","",deleted_at,NULL',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'profile_image' => 'required'
        ];
      
        $request->validate($rules);

        try {
            $password = rand(00000, 999999);  //to generate password of driver

            $inserArr = [
                'name'                      => $request->name,
                'gender'                    => $request->gender,
                'phone_number'              => $request->mobile_number,
                'phone_number_verified_at'  => now(),
                'password'                  => bcrypt($password),
                'email'                     => $request->email,
                'address'                   => $request->address,
                'city'                      => $request->city,
                'state'                     => $request->state,
                'zipcode'                   => $request->pincode,
                'status'                    => config('constants.STATUS.ACTIVE'),
                'dl_number'                 => $request->license_number ? $request->license_number : '',
                'dl_expiraion_date'         => $request->expiry_date ? $request->expiry_date : null,
                'vehicle_number'            => $request->vehicle_number ? $request->vehicle_number : '',
            ];

            // $response = CommonHelper::s3FileUpload($request->profile_image, 'drive-profile-images');
            $inserArr['profile_image'] = $request->profile_image;

            DB::transaction(function () use ($inserArr, $request, $password) {
                $data = Distributor::create($inserArr);
                $proofs = [];
                $i = 0;
                foreach ($request->proofs as $key => $value) {
                    
                    $proofs[$i]['file_url'] = CommonHelper::s3FileUpload($value, $key);
                    $proofs[$i]['type'] = $key;
                    $proofs[$i]['created_at'] = date('Y-m-d H:i:s');
                    $proofs[$i]['updated_at'] = date('Y-m-d H:i:s');
                    $proofs[$i]['distributor_id'] = $data->id;
                    $i++;
                }
                
                $data->store()->create(['store_id' => auth()->guard('store')->id()]);

                $data->proofs()->insert($proofs);
                $mailData = [
                    'email'             => $data->email,
                    'password'          => $password,
                    'mobile_num'        => $request->mobile_number,
                    'driver_name'       => $request->name,
                ];
                $data->notify(new AddDriverNotification($mailData));
            });

            return redirect('store/driver/list?status=all')->with('success', ['message' => trans('Store::home.driverAdded'),'code'=>Response::HTTP_OK]);;
        } catch (Exception $e) { 
            $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            return redirect()->back()->with('success', $http_response_header);
        }
    }

    /**
     * @desc detail page
     */
    public function show(Request $request, $id)
    {
      
        $data['driver'] = Distributor::with(['proofs'])->findOrfail($id);
        $data['avgRating'] = CommonHelper::fetchAvgRating($id, config('constants.userType.driver'));
        $data['reviewCount'] = CommonHelper::ratingReviewCount($id, config('constants.userType.driver'), true);
        $data['ratingCount'] = Rating::where(['type'=>config('constants.userType.driver'),'rated_id'=> $id])->count();

        $data['reviews']= Rating::where(['type'=>config('constants.userType.driver'),'rated_id'=> $id])->where('review','!=', null)->with(['user'])->orderBy('created_at','desc')->paginate(5);
        $data['statsticData']=CommonHelper::getStasticData($id, null, config('constants.ratingType.driver'));
        
        return view('Store::driver.detail')->with($data);
    }

    /**
     * @desc edit page
     */
    public function edit($id)
    {
        $data['driver'] = Distributor::with(['proofs'])->findOrfail($id);

        return view('Store::driver.edit')->with($data);
    }

    /**
     *@desc used to update driver detail
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
        ];

        $request->validate($rules);


        try {
            $updateArr  = [
                "name" => $request->name,
                "gender" => $request->gender,
                "address" => $request->address,
                "city" => $request->city,
                "state" => $request->state,
                "zipcode" => $request->pincode,
                "vehicle_number" => $request->vehicle_number,
                "dl_number" => $request->license_number,
                "dl_expiraion_date" =>  $request->expiry_date ? $request->expiry_date : null,
            ];

            if ($request->profile_image) {
                // $response = CommonHelper::s3FileUpload($request->profile_image, 'drive-profile-images');
                $updateArr['profile_image'] = $request->profile_image;
            }


            DB::transaction(function () use ($updateArr, $request, $id) {
                Distributor::where('id', $id)->update($updateArr);

                if ($request->proofs) {
                    $proofs = [];
                    $i = 0;
                    foreach ($request->proofs as $key => $value) {
                        $file_url = CommonHelper::s3FileUpload($value, $key);
                        DistributorProof::updateOrCreate(['distributor_id' => $id, 'type' => $key], ['file_url' => $file_url]);
                    }
                }
            });
            return redirect('store/driver/detail/' . $id)->with('success', ['message' => trans('Store::home.driver_updated'),'code'=>Response::HTTP_OK]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', ['message' => 'Something went wrong', 'code'=>$e->getCode()]);
        }
    }

    /**
     * destroy function to delete driver
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        try {
            $driver = \App\Models\Distributor::find($id);
            if($driver->admin_status == config('constants.STATUS.BLOCKED'))
            {
                return response()->json(['message' => trans('Store::home.driverBlockedByAdmin')]);
            }
            $driver->status = $request->status;
            $driver->save();
            if($driver->status == config('constants.STATUS.BLOCKED'))
            {
               $driver->tokens()->each(function ($token) {
                    $token->delete(); 
              });
            }
            $msg = ($driver->status == 'blocked') ? trans('Store::home.driverBlocked') : trans('Store::home.driverunBlocked');
            return response()->json(['message' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong']);
        }
    }





    /**
     * searchDriver
     * @param : query string
     * @return : application/json
     */

    public function searchDriver(Request $request)
    {
        $storId = Auth::guard('store')->user()->id;
        $result = DistributorStore::with(['distributor'])
            ->when($request->q, function ($q) use ($request) {
                $q->whereHas('distributor', function ($w) use ($request) {
                    $w->where('name', 'LIKE', "%$request->q%");
                });
            })

            ->whereHas('distributor', function ($query) {
                $query->where('status', '!=', config('constants.STATUS.BLOCKED'));
            })

            ->where('store_id', $storId)
            ->get();

        $data = [];

        if ($result->count()) {

            foreach ($result as $key => $row) {
                $data[]['name'] = $row->distributor->name;
            }
        }
        $data = [
            'items' => $data,
        ];

        return response()->json($data);
    }

    /**
     * checkExsitingDriverEmail
     * @param : request params
     */

    public function checkExsitingDriverEmail(Request $request)
    {
        $email = $request->get('email');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $checkExistingEmail = Distributor::where('email', $email)->first();

            if (empty($checkExistingEmail)) {
                return response("true", Response::HTTP_OK);
            } else {
                return response(trans("false"), Response::HTTP_OK);
            }
        } else {

            $phone = $request->get('mobile_number');
            $checkExistingPhone = Distributor::where('phone_number', $phone)->first();

            if (empty($checkExistingPhone)) {
                return response("true", Response::HTTP_OK);
            } else {
                return response(trans("false"), Response::HTTP_OK);
            }
        }
    }


    /**
     * change driver password
     * @param : request params
     */

    public function changeDriverPass(Request $request)
    {

        $rules = [
            'email'         => 'required',
            'password'      => 'required',
            'name'          => 'required',
            'mobile_num'    => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        try {
            if ($validator->fails()) {
                return response()->json(['errors', $validator->errors(),'code'=>Response::HTTP_NOT_FOUND]);
            }

            $email = $request->get('email');
            $password = $request->get('password');
            
            $data= Distributor::where('email',$email)->first();
            if($data){
                $data->password=  Hash::make($password);
                $data->save();
            }

            $mailData = [
                'email' => $data->email,
                'password' => $password,
                'mobile_num' => $request->mobile_num,
                'driver_name' => $request->name,
                'is_update' => config('constants.YES'),
            ];

            $data->notify(new AddDriverNotification($mailData));
            $response=[
                 'message'=>trans('Store::home.change_password_success'),
                 'code'=>Response::HTTP_OK,
            ];
        } catch (Exception $e) {
            $response=[
                'message' => $e->getMessage(),
                 'code' => $e->getCode()
            ];
        }
        return response()->json($response);
    }
}
