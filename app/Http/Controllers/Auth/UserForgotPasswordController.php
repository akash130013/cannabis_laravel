<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;
use DB;
use App\User;
use App\Modules\Admin\Models\CannabisLog;
use App\Rules\validatePhone;
use Illuminate\Support\Facades\Hash;



class UserForgotPasswordController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

  use SendsPasswordResetEmails;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest:users');
  }

  public function showLinkRequestForm(Request $request)
  {
    $params = $request->get('params', '');

    if (!empty($params)) {
      $params = unserialize(base64_decode($params));
    }
    return view('auth.passwords.user-email', ['previousData' => $params]);
  }

  public function otpForm($params)
  {

    $result = @unserialize((base64_decode($params)));

    try {

      if (empty($result)) {
        throw new Exception(trans('Store::home.invalid_params'), Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      return view('auth.passwords.user-otp', ['otp' => $result['otp'], 'phone' => $result['full_phone'], 'phone_code' => $result['phone_code'], 'first_step_input' => $result]);
    } catch (Exception $e) {

      $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];

      Log::error(trans('User::home.error_processing_request'), $errors);

      abort('404');
    }
  }

  public function sendOtpPage(Request $request)
  {

    
    /*
    |
    | define validation rules 
    |
    */ 
    try {
      $rules = [
        'phone' => 'required|min:5'
      ];

      /*
         |
         | define validation messages
         |
         */

      $messages = [
        'phone.required' => trans('User::home.not_valid_phone'),
      ];

      $v = Validator::make($request->all(), $rules, $messages);

      if ($v->fails()) {
        return Redirect::back()->with('errors', $v->errors());
      }

      $phoneNumber=$request->full_phone;
      $country_code=$request->phone_code;
      $phoneNumber  = preg_replace("/^\+?{$country_code}/", '',$phoneNumber);   //to remove country code and 0 from input
      $user=User::where(['phone_number'=> $phoneNumber,'deleted_at' => null])->first();
      if (!$user) {  // user found
        throw new Exception(trans('User::home.not_valid_phone'), Response::HTTP_NOT_FOUND);
       }
       if($user->status != config('constants.STATUS.ACTIVE'))
       {
        throw new Exception(trans('User::home.blocked_by_admin'), Response::HTTP_NOT_FOUND);
       }
         /*
         |
         | send otp to mobile.
         |
         */

      $otp = rand(1000, 9999);

     
      $phone_code = $request->get('phone_code');
      $full_phone = $request->get('full_phone');
      $sms = [];
      $sms['otp'] = hash('sha256', $otp);
      $sms['phone'] = $phoneNumber;
      $sms['phone_code'] = $phone_code;
      $sms['full_phone'] = $full_phone;
        // $this->sendOTP($full_phone, $otp);
       
      return redirect()->route('users.otp', ['params' => base64_encode(serialize($sms))]);
    } catch (\Exception $e) {
      $error['message']    = $e->getMessage() . 'on line ' . $e->getLine() . 'get file' . $e->getFile();
      $error['code'] = $e->getCode();
      Log::error($error);
      CannabisLog::create($error);

      $http_response_header = ['code' => Response::HTTP_NOT_FOUND, 'message' => $e->getMessage()];
     
      return redirect()->back()->with('error', $http_response_header);
    }
  }






  //defining which password broker to use, in our case its the admins
  protected function broker()
  {
    return Password::broker('users');
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
   * ResentMobileOTPcode
   * @param : mobile number 
   * @return : application/json
   */

  public function ResentMobileOTPcode(Request $request)
  {
    try {
     
      $otp = mt_rand(1000,9999); 
      // $flag = $this->sendOTP($request->phone,  $otp);
      $flag=true;

      if ($flag) {
        $http_response_header = ['code' => Response::HTTP_OK, 'messages' => trans('Store::home.phone_otp_send'), 'hash' => hash('sha256', $otp)];
      } else {
        $http_response_header = ['code' => Response::HTTP_NOT_FOUND, 'messages' => trans('Store::home.error')];
      }
      // to do for mobile otp verification mail
      return response()->json($http_response_header);
    } catch (\Exception $e) {
      $error['message']    = $e->getMessage() . 'on line ' . $e->getLine() . 'get file' . $e->getFile();
      $error['code'] = $e->getCode();
      Log::error($error);
      CannabisLog::create($error);
      return false;
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
      DB::beginTransaction();
      $otpEntered = $request->get('otp');
      $otpHash = $request->get('otphash');

      $params = $request->all();
      if ($otpEntered==config('constants.BY_PASS_OTP')) {  //by pass otp
        return redirect()->route('users.password.reset', ['params' => base64_encode(serialize($params))]);
      }

      if (hash('sha256', $otpEntered) != $otpHash) {

        return Redirect::back()->with('otperror', trans('User::home.invalid_otp'));
      }
      
      //   dd($params);
      DB::commit();
    } catch (QueryException $e) {
      DB::rollBack();
      return Redirect::back();
    }
    /*
        |
        | let user to send user password page
        |
        */

    return redirect()->route('users.password.reset', ['params' => base64_encode(serialize($params))]);
  }


  public function resetPassword(Request $request)
  {

    $rules = [
      'password' => 'required|confirmed|min:6',
    ];



    $validation = Validator::make($request->all(), $rules);

    if ($validation->fails()) {

      return Redirect::back()->with('errors', $validation->errors());
    }
    // dd($request->all());
    #update user status with verified user.

    try {
      DB::beginTransaction();
      $email = decrypt($request->email);
      $user = User::where('email', $email)->first();
      $user->password = Hash::make($request->get('password'));

      if (!$user->save()) {
        DB::rollBack();
        throw new Exception(config('User::home.error'), Response::HTTP_NOT_FOUND);
      }
      DB::commit();
    } catch (QueryException $e) {
      DB::rollBack();
      return Redirect::back();
    }
    return redirect()->route('users.logout');
  }
}
