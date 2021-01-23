<?php


namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Store\Libraries\HomeLibrary;
use App\Modules\Store\Models\HomeConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\MobileVerificationReqest;
use App\Notifications\SendSignoutOtpNotification;
use App\Store;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Home extends Controller
{

  const EMAIL_VERIFIED = "verified";

  /**
   * @param : null
   * @return : application/html
   * 
   */


  function index()
  {
    return view("Store::dashboard.index");
  }

  /**
   * @param : null
   * @return : application/html
   */

  public function showStoreProfile()
  {
    return view('Store::dashboard.profile');
  }

  /**
   * RegisterStoreUser
   * @param : null 
   * @return : application/html
   */

  public function RegisterStoreUser(Request $request)
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
    // dd($params);
    return view('Store::register.first-step', ['previousData' => $params]);
  }

  /**
   * ShowSecondStep
   * @param : null
   * @return : application/html
   */

  public function ShowSecondStep(Request $request)
  {


    $rules = [
      'first_name' => 'required',

      'second_name' => 'required',

      'email' => 'required|unique:store'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {

      return Redirect::back()->with('errors', $validator->errors())->withInput();
    }

    $params = base64_encode((serialize($request->all())));

    return redirect()->route('store.show.password.verification', ['params' => $params]);
  }

  /**
   *  showPasswordVerificationForm
   *  @param : null
   *  @return : application/json
   * 
   */

  public function showPasswordVerificationForm($params)
  {

    $result = @unserialize((base64_decode($params)));

    try {

      if (empty($result)) {
        throw new Exception(trans('Store::home.invalid_params'), Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      return view('Store::register.second-step', ['first_step_input' => $result]);
    } catch (Exception $e) {

      $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
      Log::error(trans('User::home.error_processing_request'), $errors);
      abort(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  /**
   * ShowThirdStep
   * @param : null
   * @return : application/html
   */

  public function ShowThirdStep(Request $request)
  {
    $params = $request->all();
    $email = $request->get('email');

    $user = new User();
    $user->email = $email;
    $otp = mt_rand(100000, 999999);
    $user->notify(new SendSignoutOtpNotification($otp));

    $params['otp'] = hash('sha256', $otp);

    return redirect()->route('store.show.password.verification.page', ['params' => base64_encode(serialize($params))]);
  }

  /**
   * showPasswordOTPEmailForm
   * @param : null
   * @return : application/json
   */

  public function showPasswordOTPEmailForm($params)
  {
    $result = @unserialize((base64_decode($params)));

    try {

      if (empty($result)) {
        throw new Exception(trans('Store::home.invalid_params'), Response::HTTP_UNPROCESSABLE_ENTITY);
      }


      return view('Store::register.third-step', ['second_step_input' => $result, 'otp' => $result['otp']]);
    } catch (Exception $e) {

      $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
      Log::error(trans('User::home.error_processing_request'), $errors);
      abort(Response::HTTP_INTERNAL_SERVER_ERROR);
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
    $otp = mt_rand(100000, 999999);
    $user->notify(new SendSignoutOtpNotification($otp));

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

  public function ShowFourStep(Request $request)
  {

    $rules = [
      'otp' => 'required'
    ];

    $messages = [
      'otp.required' => trans('Store::home.otp_field_required')
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

      return Redirect::back()->with('otperror', trans('Store::home.invalid_otp'));
    }


    #user is valid user store into the database.

    try {

      $store = new Store();
      $store->name = $request->get('first_name');
      $store->last_name = $request->get('second_name');
      $store->email = $request->get('email');
      $store->password = Hash::make($request->get('password'));
      $store->is_email_verified = self::EMAIL_VERIFIED;
      $store->phone = null;
      $store->save();
    } catch (QueryException $e) {

      return Redirect::back();
    }

    /*
        |
        | let user to logged in but show mobile verification form for verification of mobile.
        |
        */

    $credential = [
      'email' => $request->get('email'),
      'password' => $request->get('password')
    ];

    if (Auth::guard('store')->attempt($credential)) {

      // return redirect()->intended('store/dashboard');
            return redirect()->route('store.dashboard');

      
    }
  }
}
