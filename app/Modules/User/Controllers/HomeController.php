<?php


namespace App\Modules\User\Controllers;

use App\Events\LPCreditEvent;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserMailVerifyNotification;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use App\Modules\User\Models\UserDetail;
use App\Rules\validatePhone;
use App\Rules\referalValidate;


use DB;
use App\Helpers\TwilioService;
use App\Notifications\ComingSoonNotification;
use App\Notifications\SendSignoutOtpNotification;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session as FacadesSession;

class HomeController extends Controller
{

  const EMAIL_VERIFIED = "verified";

  private $twilio = null;

  public function __construct()
  {
    $this->twilio = new TwilioService;
  }


  /**
   * RegisterStoreUser
   * @param : null 
   * @return : application/html
   */

  public function index(Request $request)
  {

    /*
    |
    | show prefilled information when user click on not right link
    |
    */
    return view('User::register.coming-soon');
    // return view('User::register.home');
  }

/**
 * @desc comming soon
 * @pram $request
 */
  public function comingSoon(Request $request)
  {

    $rules = [
      'full_name' => 'required',
      'email' => 'required',
      'phone' => 'required',
      'favourite_product' =>'required',
    ];
   
    try {
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return Redirect::back()->with('errors', $validator->errors())->withInput();
      }

      
      $user = new User();
      // $user->email = $request->email;
      $sendData = [
        'full_name' => $request->get('full_name'),
        'phone'  => $request->get('phone'),
        'email' => $request->get('email'),
        'favourite_product' => $request->get('favourite_product'),
      ];
      
    
       $mail=['Keri@420kingdom.com','jeffrey@420kingdom.com','mario@420kingdom.com'];
      // $mail=['akash.patel@appinventiv.com','manu.jain@appinventiv.com','chetan.sharma@appinventiv.com'];

       foreach($mail as $key=>$value){
          $user->email=$value;
          $user->notify(new ComingSoonNotification($sendData));
       }   
      //  $request->session()
       $request->session()->flash('message', 'You are submited request successfully. We will get back to you very soon!'); 
       $request->session()->flash('alert-class', 'alert-danger'); 
      return redirect()->back();

    } catch (Exception $e) {
      
      return CommonHelper::handleException($e);
    }
  }



  /**
   * RegisterStoreUser
   * @param : null 
   * @return : application/html
   */
  public function RegisterUser(Request $request)
  {

    /*
    |
    | show prefilled information when user click on not right link
    |
    */

    $params = $request->get('params', '');

    if (!empty($params)) {
      $params = unserialize(base64_decode($params));
    }
    return view('User::register.signup', ['previousData' => $params]);
  }



  /**
   * ShowSecondStep
   * @param : null
   * @return : application/html
   */

  public function ShowSecondStep(Request $request)
  {


    $rules = [
      'user_name' => 'required',
      'email' => 'nullable|unique:users,email,NULL,id,deleted_at,NULL',
      'password' => 'required',
      'phone_code' => 'required',
      'full_phone' => 'required',
      'phone' => ['required', new validatePhone()],
      'referal_code' => ['sometimes', new referalValidate()],
    ];



    try {
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return Redirect::back()->with('errors', $validator->errors())->withInput();
      }

      if (isset($request->referal_code) && !empty($request->referal_code)) {
        $user = USER::where('user_referral_code', $request->referal_code)->exists();

        if (!$user) {
          throw new Exception(trans('User::home.referal_code_not_found'), Response::HTTP_NOT_FOUND);
        }
      }


      $otp = mt_rand(1000, 9999);
      $params = $request->all();

      //mobile verification send otp

      $phone = $request->get('phone');
      $phone_code = $request->get('phone_code');
      $full_phone = $request->get('full_phone');
      $params['otp'] = hash('sha256', $otp);
      $params['phone'] = $phone;
      $params['phone_code'] = $phone_code;
      $params['full_phone'] = $full_phone;

      // $flag = $this->sendOTP($full_phone, $otp);

      // if (!$flag) {
      //   throw new Exception(trans('User::home.error'), Response::HTTP_NOT_FOUND);
      // }

    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
    return redirect()->route('users.show.mobile.otp.verification.page', ['params' => base64_encode(serialize($params))]);
  }


  /**
   * @desc send mobileotpcode
   */
  public function mobileOTPcode(Request $request)
  {

    try {
      $phoneNumber = $request->phone;
      $country_code = $request->dialCode;

      $phoneNumber  = preg_replace("/^\+?{$country_code}/", '', $phoneNumber);

      if (User::where('phone_number', '=', $phoneNumber)->exists()) {  // user found
        throw new Exception(trans('User::home.existing_number'), Response::HTTP_NOT_IMPLEMENTED);
      }


      $otp = mt_rand(1000, 9999);

      $sid = $this->twilio->sms($request->phone, $otp, $country_code, $phoneNumber);

      $http_response_header = ['code' => Response::HTTP_OK, 'sid' => $sid, 'messages' => trans('Store::home.phone_otp_send'), 'hash' => hash('sha256', $otp)];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($http_response_header);
  }



  /**
   * @desc used to send OTP
   */
  public function sendOTP($full_phone, $otp)
  {
    $accountSid = config('services.twilio.TWILIO_ACCOUNT_SID');
    $authToken  = config('services.twilio.TWILIO_AUTH_TOKEN');

    // the number you'd like to send the message to
    $number =  $full_phone;

    // the body of the text message you'd like to send
    $message = trans('User::home.OTP_MSG') . $otp;

    $client = new Client($accountSid, $authToken);
    // Use the client to send text messages!
    $result = $client->messages->create(
      $number,
      [
        // A Twilio phone number you purchased at twilio.com/console
        'from' => config('services.twilio.TWILIO_FROM'),
        'body' => $message,
      ]
    );

    if ($result->sid) {
      return true;
    }
    return false;
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
      return view('User::register.mobile_otp_verify', ['otp' => $result['otp'], 'phone' => $result['full_phone'], 'phone_code' => $result['phone_code'], 'first_step_input' => $result]);
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

    try {
      //  DB::beginTransaction();
      $user = new User();

      if (isset($request->email) && !empty($request->email)) {
        $user->email = $request->get('email');
        $time = now()->addMinute(config('constants.EMAIL_EXPIRE_TIME'));  //set validity of the url
        $token = [
          'email' => $request->get('email'),
          'time' => $time,
        ];
        $encToken = encrypt($token);
        $user->notify(new UserMailVerifyNotification($encToken));  //send a url for the verification link
        $user->email_verified_token = $encToken;
      }

      $phoneNumber = $request->get('full_phone');
      $country_code = $request->get('country_code');
      $phoneNumber  = preg_replace("/^\+?{$country_code}/", '', $phoneNumber);   //to remove country code and 0 from input


      $user->name = $request->get('user_name');
      $user->password = Hash::make($request->get('password'));
      $user->phone_number = $phoneNumber;
      $user->country_code =  '+' . $request->get('country_code');
      $user->phone_number_verified_at = config('constants.DEFAULT_DB_DATE_TIME_FORMAT');
      $user->referred_by = $request->get('referal_code'); ///code refered by someone
      $user->save();
      $val = mt_rand(1000, 9999);
      $user->user_referral_code = $user->id . 'KING' . $val;
      $user->save();

      if (!empty($request->get('referal_code'))) {
        $referredUserId = User::where('user_referral_code', $request->get('referal_code'))->first();
        if ($referredUserId) {
          event(new LPCreditEvent($referredUserId->id, 'referred', 'Loyalty Point credit on referral_code by ' . $user->id));
        }
      }
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }


    /*
        |
        | let user to logged in but show age verification form for verification of mobile.
        |
        */

    $credential = [
      'phone_number' => $phoneNumber,
      'password' => $request->get('password')
    ];

    if (Auth::guard('users')->attempt($credential)) {

      return redirect()->route('users.dashboard');
    }
  }

  /**
   * ResentMobileOTPcode
   * @param : mobile number 
   * @return : application/json
   */

  public function ResentMobileOTPcode(Request $request)
  {

    try {

      $otp = mt_rand(1000, 9999);
      // $flag = $this->sendOTP($request->phone,  $otp);
      $flag = true;

      if ($flag) {
        $http_response_header = ['code' => Response::HTTP_OK, 'messages' => trans('Store::home.phone_otp_send'), 'hash' => hash('sha256', $otp)];
      } else {
        $http_response_header = ['code' => Response::HTTP_NOT_FOUND, 'messages' => trans('Store::home.error')];
      }
      // to do for mobile otp verification mail

      return response()->json($http_response_header);
    } catch (\Exception $e) {
      return CommonHelper::handleException($e);
    }
  }



  /**
   *  showOtpVerificationForm
   *  @param : null
   *  @return : application/json
   * 
   */

  public function showOtpVerificationForm($params)
  {

    $result = @unserialize((base64_decode($params)));
    try {

      if (empty($result)) {
        throw new Exception(trans('Store::home.invalid_params'), Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      return view('User::register.email_otp_verify', ['first_step_input' => $result]);
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
  }




  /**
   * ResendOTP
   * @param : json encoded string to send otp to mobile number.
   * @return : application/json
   */

  public function ResendOTP(Request $request)
  {

    $data = unserialize((base64_decode(($request->get('data')))));

    $user = new User();
    $user->email = $data['email'];
    $otp = mt_rand(1000, 9999);
    $user->notify(new SendSignoutOtpNotification($otp));
    // $user->notify(new SendSignoutOtpNotification());

    return response()->json(['code' => Response::HTTP_OK, 'hash' => hash('sha256', $otp), 'messages' => trans('Store::home.email_otp_send')]);
  }

  /**
   * 
   */

  /**
   * ShowFourStep 
   * @param : null
   * @return : application/html
   */

  public function ShowThreeStep(Request $request)
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

    /*
        |
        | validate user otp received from database.
        |
        */

    $otpEntered = $request->get('otp');
    $otpHash = $request->get('otphash');

    if (hash('sha256', $otpEntered) != $otpHash) {

      return Redirect::back()->with('otperror', trans('User::home.invalid_otp'));
    }


    #user is valid users into the database.

    try {
      $user = new User();
      $user->name = $request->get('user_name');
      $user->email = $request->get('email');
      $user->password = Hash::make($request->get('password'));
      $user->email_verified_at = config('constants.DEFAULT_DB_DATE_TIME_FORMAT');
      $user->phone_number = $request->get('phone');
      $user->save();
      $val = rand(1000, 9999);
      $user->referral_code = 'KING' . $user->id . $val;
      $user->save();
    } catch (Exception $e) {
      return CommonHelper::handleException($e);
    }
    /*
        |
        | let user to logged in but show age verification form for verification of mobile.
        |
        */

    $credential = [
      'email' => $request->get('email'),
      'password' => $request->get('password')
    ];

    if (Auth::guard('users')->attempt($credential)) {

      // return redirect()->intended(route('users.dashboard'));
      return redirect()->route('users.dashboard');
    }
  }


  /**
   * @desc check referal validity
   */

  // public function checkReferalValidity(Request $request)
  // {
  //   try {
  //     //Check is request is Ajax
  //     if (1 != $request->ajax()) {
  //       $responseArray = [
  //         'code' => Response::HTTP_FORBIDDEN,
  //         'msg' => trans('Admin::messages.no_direct_access'),
  //       ];

  //       return (new Response($responseArray, Response::HTTP_FORBIDDEN))
  //         ->header('Content-Type', 'application/json');
  //     }
  //     if (empty($request->refer_code) || !isset($request->refer_code)) {
  //       throw new Exception(trans('User::home.referal_code_not_found'), Response::HTTP_NOT_FOUND);
  //     }

  //     $user = USER::where('user_referral_code', $request->refer_code)->exists();

  //     if (!$user) {
  //       throw new Exception(trans('User::home.referal_code_not_found'), Response::HTTP_NOT_FOUND);
  //     }
  //     $reponse = [
  //       "message" => trans('User::home.valid_code'),
  //       "code" => Response::HTTP_OK,
  //     ];
  //   } catch (Exception $ex) {
  //     $reponse = [
  //       "message" => $ex->getMessage(),
  //       "code" => $ex->getCode(),
  //     ];
  //   }
  //   return response()->json($reponse);
  // }


  public function checkReferalValidity(Request $request)
  {

    if (1 != $request->ajax()) {
      $responseArray = [
        'code' => Response::HTTP_FORBIDDEN,
        'msg' => trans('Admin::messages.no_direct_access'),
      ];

      return (new Response($responseArray, Response::HTTP_FORBIDDEN))
        ->header('Content-Type', 'application/json');
    }

    $refer_code = $request->get('referal_code');

    if (empty($refer_code) || !isset($refer_code)) {
      return response("true", Response::HTTP_OK);
    }


    $user = USER::where('user_referral_code', $refer_code)->exists();

    if ($user) {
      return response("true", Response::HTTP_OK);
    } else {
      return response(trans("false"), Response::HTTP_OK);
    }
  }

  /**
   * updateCurrentLocation
   * @param : request params
   * @return : application/json
   */

  public function updateCurrentLocation(Request $request)
  {


    try {
      $lat = $request->get('lat');
      $lng = $request->get('lng');
      $userId = Auth::guard('users')->user()->id;

      $userData = UserDetail::where('user_id', $userId)->first();
      $userData->formatted_address = $request->get('formatted_address');
      $userData->zipcode = $request->get('postal_code', '');
      $userData->ip = $request->get('ip', '');
      $userData->lat = $lat;
      $userData->lng = $lng;
      $userData->save();

      $response = ['code' => Response::HTTP_OK, 'message' => trans('User::home.user_location_updated')];
    } catch (Exception $e) {
      return CommonHelper::catchException($e);
    }

    return response()->json($response);
  }
}
