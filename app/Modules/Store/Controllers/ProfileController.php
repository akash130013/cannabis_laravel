<?php


namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MObileValidationRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Models\ZipcodeTimezone;
use App\Modules\Store\Models\StoreDetails;
use Illuminate\Support\Facades\Validator;
use Hash;
use DB;
use Exception;
use App\Store;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Auth;
use App\Modules\Admin\Models\CannabisLog;
use App\Modules\Store\Models\StoreTiming;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateStoreRequestAddress;
use App\Models\StoreDetail;
use App\Modules\Store\Models\StoreImages;
use App\Rules\ValidateStoreTiming;

class ProfileController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $authData = Auth::guard('store')->user();

        $storeId = $authData->id;
        $profile = $authData->avatar ?? config('constants.DEAFULT_IMAGE.USER_IMAGE');
        $storeDetails = StoreDetails::where('store_id', $storeId)->first();

        $storeTimings = StoreTiming::where('store_id', $storeId)->get();


        return view('Store::profile.index', compact('storeDetails', 'storeTimings', 'profile'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showStoreImage()
    {

        $storeID = Auth::guard('store')->user()->id;
        $images = StoreImages::where('store_id', $storeID)->get();
        $storeBanner=StoreDetail::select(['banner_image_url'])->where('store_id',$storeID)->first();
         

        return view('Store::profile.store-update-images', compact('images','storeBanner'));
    }

    /**
     *@desc update store images page
     *@param request parameter
     */
    public function updateStoreImage(Request $request)
    {

        $rules  = [
            'images' => 'required|array',
        ];

        $messages = [
            'images.required' => trans('Store::home.validation_message_image')
        ];


        $validation = Validator::make($request->all(), $rules, $messages);

        if ($validation->fails()) {
            return Redirect::back()->with('errors', $validation->errors())->withInput();
        }

     /*
     |
     | store user image on table.
     |
     */
        try {

            $storeID = Auth::guard('store')->user()->id;
            StoreImages::where('store_id', $storeID)->delete();
            
            $storeDetail=StoreDetail::where('store_id', $storeID)->first();
            if($request->has('bannerImage') && isset($request->bannerImage)){
              $storeDetail->banner_image_url=$request->bannerImage;
              $storeDetail->save();
            }

            $images = $request->get('images');
            foreach ($images as $key => $val) {
                $imagesData = ['store_id' => $storeID, 'file_url' => $val];
                StoreImages::create($imagesData);
            }

            return redirect()->route('storeprofile.index');
        } catch (QueryException $e) {
            $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
            Log::error(trans('User::home.error_processing_request'), $errors);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * updateMobile
     * @param : Request object
     * @return : application/html
     */

    public function updateMobile(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'contact_number'  => 'required|unique:store,phone',
                'otphash'      => 'required',
                'otp'          =>  'required',
            ]);

            if ($validator->fails()) {
                return Redirect::back()->with('errors', $validator->errors())->withInput();
            }


            $otpEntered = $request->get('otp');
            $otpHash = $request->get('otphash');

            if ($otpEntered != config('constants.BY_PASS_OTP')) {

                if (hash('sha256', $otpEntered) != $otpHash) {
                    return Redirect::back()->with('otperror', trans('User::home.invalid_otp'));
                }
            }


            /*
            |
            | validate if number aloready exits or not
            |
            */
            $phoneNumber =  $request->get('contact_number');
            /*
            |
            |   update store mobile number
            |
            */
            $user = Store::find(Auth::guard('store')->user()->id);
            $user->phone =  $phoneNumber;
            $user->save();

            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.mobile_updated')
            ];
        } catch (Exception $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }
        return Redirect::back()->with('success', $response);
    }


    /**
     * show change password screen
     */

    public function showChangePassword()
    {
        return view('Store::profile.change-password');
    }
    /**
     * updatePassword
     */

    public function updatePassword(PasswordUpdateRequest $request)
    {

        try {

            Store::find(auth()->guard('store')->user()->id)->update(['password' => Hash::make($request->new_password)]);

            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.password_updated')
            ];
        } catch (Exception $e) {

            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return Redirect::back()->with('success', $response);
    }


    /**
     * to update admin user password
     * @params request
     * @return  json
     */
    public function changePassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'old_password'  => 'required|string|min:6',
                'password'      => 'required|string|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                return Redirect::back()->with('errors', $validator->errors())->withInput();
            }
            $user = Auth::guard('store')->user();

            if (!Hash::check($request->old_password, $user->password)) {
                return Redirect::back()->withErrors(['old_password' => trans('Admin::messages.old_password_error')])->withInput();
            }
            if (Hash::check($request->password, $user->password)) {
                return Redirect::back()->withErrors(['password' => trans('Admin::messages.same_password_error')])->withInput();
            }
            $user->update(['password' => bcrypt($request->password)]);
            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('Admin::messages.password_changed_success')
            ];
            return Redirect::back()->with('success', $response);
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with('errors', $response);
        }
    }
    /**
     * public function updateStoreName
     * @method : put
     * @param : user_id
     * @return : application/json
     */

    public function updateStoreName(Request $request, $id)
    {
        try {

            $storeName = $request->get('store_name');

            if (empty($storeName)) {
                throw new Exception(trans('Store::home.store_name_field_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $id = decrypt($id);
            $user = StoreDetails::where('store_id', $id)->first();
            $user->store_name = $request->get('store_name');
            $user->save();

            $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.store_name_updated')];
        } catch (Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return Redirect::route('storeprofile.index')->with('success', $response);
    }

    /**
     * public function updateStoreName
     * @method : put
     * @param : user_id
     * @return : application/json
     */

    public function updateStoreDescription(Request $request, $id)
    {
        try {

            $storeDesc = $request->get('store_desc');

            if (empty($storeDesc)) {

                throw new Exception(trans('User::home.store_desc_field_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $id = decrypt($id);
            $storeDetail = StoreDetails::where('store_id', $id)->first();
            $storeDetail->about_store = $request->get('store_desc');
            $storeDetail->save();

            $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.store_desc_name_updated')];
        } catch (Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        } catch (QueryException $e) {

            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return Redirect::route('storeprofile.index')->with('success', $response);
    }


    /**
     * showChangeMobile
     * @param : null
     * @return : application/html
     */

    public function showChangeMobile()
    {
        return view('Store::profile.change-number');
    }


    /**
     *  show Static pages
     * @param :slug of page
     * @return : application/html
     */
    public function showStaticPage(Request $request)
    {
        
        $slug  = $request->get('slug', 'pending');
       
        if ($slug) {
            $data = StaticPage::where(['slug'=> $slug,'panel'=> 'store'])->first();
            
            if ($data) {
               
                return 'help' == $slug ? view('Store::profile.help-page', compact('data', 'slug')) : view('Store::profile.static-page', compact('data', 'slug'));
            }
            return Redirect::route('storeprofile.index');
        }
        return Redirect::route('storeprofile.index');
    }

    /**
     * editUserAddress
     * @param : null
     * @return : application/html
     */

    public function editUserAddress()
    {
        $storeId  = Auth::guard('store')->user()->id;
        $storeDetails = StoreDetails::where('store_id', $storeId)->first();
        return view('Store::profile.edit-address', compact('storeDetails'));
    }

    /**
     * updateStoreAddress
     * @param : UpdateStoreRequestAddress::class
     * @return : application/html
     */

    public function updateStoreAddress(UpdateStoreRequestAddress $request)
    {


        try {

            $storeId = Auth::guard('store')->user()->id;
            $storeDetails = StoreDetails::where('store_id', $storeId)->first();
            $storeDetails->formatted_address = $request->get('formatted_address');
            $storeDetails->lat = $request->get('lat');
            $storeDetails->lng = $request->get('lng');
            $storeDetails->save();

            if ($request->has('time_zone') && !empty($request->time_zone)) {
                $timezone = $request->time_zone;
                if ($timezone) {
                    $store = Store::find($storeId);
                    $store->time_zone = $timezone;
                    $store->save();
                }
            }


            $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.store_address_update')];
        } catch (Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return Redirect::route('storeprofile.index')->with('success', $response);
    }


    /**
     *
     *  updateStoreEmail
     *  @param : Request::class
     * @return : redirect back to main page
     */


    public function updateStoreEmail(Request $request)
    {

        try {


            $otpEntered = $request->get('otp');
            $otpHash = $request->get('otp_hash');
            $email   = $request->get('email');

            if (hash('sha256', $otpEntered) != $otpHash) {

                throw new Exception(trans('Store::home.invalid_otp'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $storeId = Auth::guard('store')->user()->id;
            $store = Store::find($storeId);
            $store->email = $email;
            $store->save();

            $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.store_email_address_updated')];
        } catch (Exception $e) {

            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return Redirect::route('storeprofile.index')->with('success', $response);
    }

    /**
     * getDeliveryAddress
     * @param : null
     * @return  : application/html
     */

    public function getDeliveryAddress()
    {
        $storeID = Auth::guard('store')->user()->id;
        $previousWorkingHours = StoreTiming::where('store_id', $storeID)->get();

        if (!empty($previousWorkingHours)) {

            $Timedata = [];
            foreach ($previousWorkingHours as $key => $val) {

                $data['isActive'] = false;

                if ($val->working_status == 'open') {
                    $data['isActive'] =  True;
                }

                $data['timeFrom'] = null;
                if ($val->start_time != config('constants.DATE.NULL_TIMER')) {
                    $data['timeFrom'] = $val->start_time;
                }

                $data['timeTill'] = null;
                if ($val->end_time != config('constants.DATE.NULL_TIMER')) {
                    $data['timeTill'] = $val->end_time;
                }

                $Timedata[] = $data;
            }
        }

        return view('Store::profile.edit-deliveryaddress', ['defaultTime' => json_encode($Timedata)]);
    }




    /**
     * storeWorkingHours
     * @param : null
     * @return : application/json
     */


    public function updateStoreWorkingHours(Request $request)
    {
        try {

            $rules = [
                'workinghours' => ['required', new ValidateStoreTiming()],
              ];
          
              $validation = Validator::make($request->all(), $rules);
          
              if ($validation->fails()) {
                $response=['code'=>Response::HTTP_NOT_FOUND,'message'=>trans('Store::home.store_timing_validation')];
                return Redirect::back()->with('success', $response);
              }

            $workingHours = $request->get('workinghours', '');

            DB::transaction(function () use($workingHours, $request) {

                $workingHours = json_decode($workingHours, true);
                $storeID = Auth::guard('store')->user()->id;

                $workingHoursBatch = [];
    
                StoreTiming::where('store_id', $storeID)->delete();

                foreach ($workingHours as $key => $val) {
                    if ($val['isActive']) {

                        $workingHoursBatch = [
                            'store_id' => $storeID, 'day' => ($key + 1), 'start_time' => $val['timeFrom'] . ':00',
                            'end_time' => $val['timeTill'] . ':00', 'working_status' => 'open'
                        ];
                    } else {

                        $workingHoursBatch = [
                            'store_id' => $storeID, 'day' => ($key + 1), 'start_time' => config('constants.DATE.NULL_TIMER'),
                            'end_time' => config('constants.DATE.NULL_TIMER'), 'working_status' => 'closed'
                        ];
                    }

                    StoreTiming::create($workingHoursBatch);
                }

            });
            $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.working_time_updated')];
            

        } catch (Exception $e) {

            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }

        return Redirect::route('storeprofile.index')->with('success', $response);
    }

    /**
     * upload profile pic
     * @request : $request
     * @return : application/json
     */
    public function uploadProfilePic(Request $request)
    {
        try {
            $storeId = Auth::guard('store')->user()->id;
            $store = Store::find($storeId);
            $data = [
                'avatar' => $request->profilePic,
            ];
            $store->update($data);
            $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.store_profile_updated')];
        } catch (Exception $e) {

            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
