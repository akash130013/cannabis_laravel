<?php


namespace App\Modules\Store\Controllers;

use App\AdminDeliveryAddress;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Store\Models\StoreDeliveryAddress;
use App\Modules\Store\Models\StoreDetails;
use App\Modules\Store\Models\StoreImages;
use App\Store;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Modules\Store\Models\StoreProofs;
use App\Modules\Store\Models\StoreTiming;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;
use App\Helpers\TwilioService;
use App\Rules\ValidateStoreTiming;
use App\Models\StoreCommision;
use App\Models\StoreDetail;

class Dashboard extends Controller
{

  const MOBILE_NOT_VERIFIED = "unverified";

  const MOBILE_VERIFIED = "verified";

  const PROFILE_COMPLETED =  1;

  public function __construct()
  {
    $this->twilio = new TwilioService;
  }

  /**
   * index
   * @param : null
   * @return : application/html
   */

  public function index()
  {

    $user = Auth::guard("store")->user();

    if ($user->is_mobile_verified == self::MOBILE_NOT_VERIFIED) {

      return redirect()->route('store.register.mobile');
    }

    if ($user->is_profile_complete) {

      return redirect()->route('store.product.dashboard');
    }
    $user->load('storeDetail');
    $storeID = $user->id;

    return view('Store::dashboard.index', ['userdata' => $user]);
  }

  /**
   * showMobileRegistration
   * @return : application/html
   */

  public function showMobileRegistration()
  {
    return view('Store::register.four-step');
  }


  /**
   * RegisterMobileNumber
   * @param : null
   * @return : application/html
   */

  public function RegisterMobileNumber(Request $request)
  {
    /*
    |
    | define validation rules
    |
    */

    try {
      $rules = [
        'full_phone' => 'required|unique:store,phone,NULL,id,deleted_at,NULL',
        'phone' => 'required',
      ];

      /*
       |
       | define validation messages
       |
       */

      $messages = [
        'full_phone.unique' => trans('User::home.phone_unique')
      ];

      $v = Validator::make($request->all(), $rules, $messages);

      if ($v->fails()) {
        return Redirect::back()->with('errors', $v->errors());
      }

      /*
       |
       | send otp to mobile.
       |
       */

      $otp = rand(1000, 9999);

      $phone = $request->get('phone');
      $phone_code = $request->get('phone_code');
      $full_phone = $request->get('full_phone');
      $sms = [];
      $sms['otp'] = hash('sha256', $otp);
      $sms['phone'] = $phone;
      $sms['phone_code'] = $phone_code;
      $sms['full_phone'] = $full_phone;

      // $sid = $this->twilio->smsStore($full_phone, $otp);
      // if (!$sid) {
      //   throw new Exception(trans('User::home.error'), Response::HTTP_NOT_FOUND);
      // }
      return redirect()->route('store.show.mobile.otp.verification.page', ['params' => base64_encode(serialize($sms))]);
    } catch (\Exception $e) {
      $error['message']    = $e->getMessage() . 'on line ' . $e->getLine() . 'get file' . $e->getFile();
      $error['code'] = $e->getCode();
      Log::error($error);

      $http_response_header = ['code' => Response::HTTP_NOT_FOUND, 'message' => $e->getMessage()];
      return redirect()->back()->with('error', $http_response_header);
    }
  }



  /**
   * showMobileVerificationOtpPage
   * @param : encrypted params
   * @return : application/json
   */

  public function showMobileVerificationOtpPage($params)
  {

    $result = @unserialize((base64_decode($params)));

    try {

      if (empty($result)) {
        throw new Exception(trans('Store::home.invalid_params'), Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      return view('Store::dashboard.otp-verify', ['otp' => $result['otp'], 'phone' => $result['full_phone'], 'phone_code' => $result['phone_code']]);
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }


  /**
   * submitMobileVerification
   * @param : otp and otp hash
   * @return : application/html
   */

  public function submitMobileVerification(Request $request)
  {

    $rules = [
      'otp' => 'required'
    ];

    $messages = [
      'otp.required' => trans('User::home.OTP_Required')
    ];


    $validation = Validator::make($request->all(), $rules, $messages);

    if ($validation->fails()) {

      return Redirect::back()->with('errors', $validation->errors());
    }

    #update user status with verified user.

    $id = Auth::guard("store")->user()->id;
    $user = Store::find($id);
    $user->is_mobile_verified = self::MOBILE_VERIFIED;
    $user->phone = $request->get('phone');
    $user->save();

    return redirect()->route('store.show.business.name.page');
  }


  /**
   * showBusinessNamePage
   * @param : null
   * @return : application/html
   */

  public function showBusinessNamePage()
  {
    return view('Store::dashboard.business-name');
  }


  /**
   * StoreBusinessName abort('404');
   * @param : null
   * @return : application/html
   */

  public function StoreBusinessName(Request $request)
  {

    $rules = [
      'business_name' => 'required'
    ];

    $validation = Validator::make($request->all(), $rules);;

    if ($validation->fails()) {
      return Redirect::back()->with('errors', $validation->errors())->withInput();
    }

    $id = Auth::guard("store")->user()->id;
    $user = Store::find($id);
    $user->business_name = $request->get('business_name');
    $user->save();

    return view('Store::dashboard.business-docs');
  }

  /**
   * storeDocumentProof
   * @param : null
   * @return : application/html
   *
   */

  public function storeDocumentProof(Request $request)
  {

    try {
      $rules = [
        'licence_number' => 'required',
        'file_input' => 'required'
      ];

      $validation = Validator::make($request->all(), $rules);

      if ($validation->fails()) {
        return Redirect::back()->with('errors', $validation->errors())->withInput();
      }

      $id = Auth::guard("store")->user()->id;

      Store::where('id', $id)->update(['licence_number' => $request->input('licence_number')]);  //update licence number

      $proof = new StoreProofs();
      $proof->fileurl = $request->get('file_input');
      $proof->store_id = $id;
      $proof->save();

      return redirect()->route('store.dashboard');
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }

  /**
   * storeDetails
   * @param : null
   * @return : application/html
   */

  public function storeDetails(Request $request)
  {

    $rules = [
      'store_name' => 'required',
      'address' => 'required',
      'contact_number' => 'required'
    ];

    $validation = Validator::make($request->all(), $rules);

    if ($validation->fails()) {
      return Redirect::back()->with('errors', $validation->errors())->withInput();
    }

    try {
      $storeID = Auth::guard('store')->user()->id;

      $existingStore = StoreDetails::where('store_id', $storeID)->first();

      if (!empty($existingStore)) {

        StoreDetails::where('store_id', $storeID)

          ->update([
            'about_store'          => $request->get('about'),
            'lat'                  => $request->get('lat'),
            'lng'                  => $request->get("lng"),
            'formatted_address'    => $request->get('address'),
            'contact_number'       => $request->get('contact_number'),
            'store_name'           => $request->get('store_name')
          ]);
      } else {

        StoreDetails::create([
          'store_id'             => $storeID,
          'about_store'          => $request->get('about'),
          'lat'                  => $request->get('lat'),
          'lng'                  => $request->get("lng"),
          'formatted_address'    => $request->get('address'),
          'contact_number'       => $request->get('contact_number'),
          'store_name'           => $request->get('store_name')
        ]);
      }

      $store = Store::find($storeID);
      if ($request->has('time_zone') && !empty($request->time_zone)) {
        $store->time_zone = $request->time_zone;
        $store->save();
      }
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }

    return redirect()->route('store.show.working.hours');
  }

  /**
   * showStoreWorkingHours
   * @param : null
   * @return : application/html
   */


  public function storeShowHours()
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

    return view('Store::dashboard.operating-hours', ['defaultTime' => json_encode($Timedata)]);
  }


  /**
   * storeWorkingHours
   * @param : null
   * @return : application/json
   */


  public function storeWorkingHours(Request $request)
  {

    $rules = [
      'workinghours' => ['required', new ValidateStoreTiming()],
    ];

    $validation = Validator::make($request->all(), $rules);

    if ($validation->fails()) {

      return Redirect::back()->with('errors', $validation->errors())->withInput();
    }

    try {


      DB::transaction(function () use ($request) {

        $workingHours = json_decode($request->get('workinghours'), true);

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
      return redirect()->route('show.store.images');
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }


  /**
   * showStoreImagesPage
   * @param : null
   * @return : application/json
   */

  public function showStoreImagesPage()
  {
    $storeID = Auth::guard('store')->user()->id;

    $images = StoreImages::where('store_id', $storeID)->get();
    $storeBanner = StoreDetail::select(['banner_image_url'])->where('store_id', $storeID)->first();

    return view('Store::dashboard.store-images', ['images' => $images, 'storeBanner' => $storeBanner]);
  }


  /**
   * storeImagesUpload
   * @param : null
   * @return : application/json
   */

  public function storeImagesUpload(Request $request)
  {

    $rules  = [
      'images' => 'required|array',
      'bannerImage' => 'required',
    ];

    $messages = [
      'images.required' => trans('Store::home.validation_message_image'),
      'bannerImage.required' => trans('Store::home.validation_message_banner')
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
      $storeDetail = StoreDetail::where('store_id', $storeID)->first();
      if ($request->has('bannerImage') && isset($request->bannerImage)) {
        $storeDetail->banner_image_url = $request->bannerImage;
        $storeDetail->save();
      }
      StoreImages::where('store_id', $storeID)->delete();
      $images = $request->get('images');
      foreach ($images as $key => $val) {
        $imagesData = ['store_id' => $storeID, 'file_url' => $val];
        StoreImages::create($imagesData);
      }

      return redirect()->route('store.show.delivery.page');
    } catch (QueryException $e) {
      return CommonHelper::handleException($e);
    }
  }

  /**
   * showDeliveryLocation
   * @param : null
   * @return : application/html
   */

  public function showDeliveryLocation()
  {

    $storeID = Auth::guard('store')->user()->id;
    $storeDeliveryAddress = StoreDeliveryAddress::where('store_id', $storeID)->get();

    return view('Store::dashboard.store-delivery-location', ['store_delivery_address' => $storeDeliveryAddress]);
  }

  /**
   * storeSubmitStoreDeliveryAddress
   * @param : null
   * @return redirect to product dashboard
   */

  public function storeSubmitStoreDeliveryAddress(Request $request)
  {

    $rules = [
      'address' => 'required',
      'lat' => 'required',
      'lng' =>  'required',
    ];
    $message = [
      'address.required' => 'Please select address',
    ];

    $validation = Validator::make($request->all(), $rules, $message);

    if ($validation->fails()) {
      return Redirect::back()->with('errors', $validation->errors())->withInput();
    }


    try {

      $zipcode  = $request->get('postal_code', '');
      $storeDeliveryAddress = StoreDeliveryAddress::firstOrNew(['zip_code' => $zipcode]);
      $storeDeliveryAddress->store_id = Auth::guard('store')->user()->id;
      $storeDeliveryAddress->formatted_address = $request->get('address');
      $storeDeliveryAddress->zip_code = $request->get('postal_code', '');
      $storeDeliveryAddress->lat = $request->get('lat');
      $storeDeliveryAddress->lng = $request->get('lng');
      $storeDeliveryAddress->save();

      $response  = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.delivery_address_added')];
    } catch (QueryException $e) {
      return CommonHelper::handleException($e);
    }
    return Redirect::back()->with('success', $response);
  }


  /**
   * updateStoreDeliveryLocationStatus
   * @param : array of encrypted id and status ,boolean value of deleted
   * @return : return to view page
   */

  public function updateStoreDeliveryLocationStatus($id, $deleted = false)
  {

    $response = ['code' => Response::HTTP_OK, 'message' => 'success'];
    try {

      [$addressID, $status] = decrypt($id);
      if (empty($addressID)) {
        throw new Exception("Error processing request", Response::HTTP_UNPROCESSABLE_ENTITY);
      }
      if ($deleted == true) {
        StoreDeliveryAddress::where('id', $addressID)->delete();
        $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.locationDeleted')];
      } else {
        $deliveryAddress =  StoreDeliveryAddress::find($addressID);
        $delivery =  AdminDeliveryAddress::where('zipcode', $deliveryAddress->zip_code)->first();
        if ($delivery->status == config('constants.STATUS.BLOCKED')) {
          $response = ['code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'message' => trans('Store::home.locationBlockedByAdmin')];
        } else {
          $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.locationActivated')];
          $updatedStatus = config('constants.STATUS.ACTIVE');
          if ($status == 'active') {
            $updatedStatus = config('constants.STATUS.BLOCKED');
            $response = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.locationBlocked')];
          }
          $data = ['status' => $updatedStatus];
          $deliveryAddress->update($data);
        }
      }
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }

    return redirect()->back()->with('success', $response);
  }


  /**
   * removeStoreDeliveryLocation
   * @param :null
   */
  public function removeStoreDeliveryLocation(Request $request)
  {
    try {
      $response = ['code' => Response::HTTP_OK, 'message' => 'success'];
      $addressID = $request->get('params');
      if (empty($addressID)) {
        throw new Exception("Error processing request", Response::HTTP_UNPROCESSABLE_ENTITY);
      }
      StoreDeliveryAddress::where('id', $addressID)->delete();
    } catch (QueryException $e) {

      $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
    } catch (Exception $e) {
      $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
    }
    Log::error(trans('User::home.error_processing_request'), $response);
    return Redirect::back();
  }

  /**
   * submitFinalProfile
   * @param : null
   * @return : return to product page
   */

  public function submitFinalProfile()
  {

    try {
      $userID = Auth::guard('store')->user()->id;
      $deliveryAddressExists = StoreDeliveryAddress::where('store_id', $userID)->exists();
      if (!$deliveryAddressExists) {
        $response =  ['code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'message' => 'Please select atleast one delivery location to proceed.'];

        return redirect()->back()->with(['success' => $response]);
      }
      $user = Store::where('id', $userID)->first();
      $user->is_profile_complete = self::PROFILE_COMPLETED;
      $user->save();

      /*
      |
      |
      | create store commision here already set by admin.
      |
      */
      $setStoreCommission = StoreCommision::firstOrNew(['store_id' => $userID]);
      $setStoreCommission->commison_percentage = config('constants.DEFAULT_STORE_COMMISION');
      $setStoreCommission->save();
    } catch (QueryException $e) {
      $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
      return Redirect::back()->with('error', $response);
    }

    return Redirect()->route('store.product.dashboard');
  }

  /**
   * ResentMobileOTPcode
   * @param : mobile number
   * @return : application/json
   */

  public function ResentMobileOTPcode(Request $request)
  {

    try {
      $phoneNumber = $request->phone;

      if (Store::where('phone', '=', $phoneNumber)->where('deleted_at', null)->exists()) {  // user found
        throw new Exception(trans('User::home.existing_number'), Response::HTTP_NOT_IMPLEMENTED);
      }
  
      $otp = mt_rand(1000, 9999);
      // $sid = $this->twilio->smsStore($request->phone, $otp);
     
      $http_response_header = ['code' => Response::HTTP_OK, 'messages' => trans('Store::home.phone_otp_send'), 'hash' => hash('sha256', $otp)];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($http_response_header);
  }

  /**
   * removeUploadedImages
   * @param : id , storeID
   * @return : application/json
   */

  public function removeUploadedImages(Request $request)
  {

    $id = $request->get('id', '');

    if (!empty($id)) {
      $storeID = $request->get('storeID');
      StoreImages::where('id', $id)
        ->where('store_id', $storeID)
        ->delete();

      $http_response_header = [
        'code' => Response::HTTP_OK,
        'message' => trans('Store::home.images_removed')
      ];

      return response()->json($http_response_header);
    }
  }
}
