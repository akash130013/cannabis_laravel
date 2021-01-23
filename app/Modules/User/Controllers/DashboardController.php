<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\User\Models\UserProof;
use App\Modules\User\Models\UserDetail;
use App\Modules\Admin\Models\CannabisLog;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Input;
use DB;
use Carbon\Carbon;


class DashboardController extends Controller
{

  const MOBILE_NOT_VERIFIED = "unverified";

  const MOBILE_VERIFIED = "verified";

  const PROFILE_COMPLETED =  1;


  /**
   * index
   * @param : null
   * @return : application/html
   */

  public function index(Request $request)
  {
    try {

      $user = Auth::guard('users')->user();


      if (is_null($user->location_updated_at)) {     //if delivery location is not updated
        return redirect()->route('user.show.delivery.page');
      }

      $query = Input::get();

      $params = [
        'longitude' => session()->get('userdetail')->lng,
        'latitude' => session()->get('userdetail')->lat,
        'is_trending' => 1,
        'unique' => 'product_id',
      ];



      $trendingProduct = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product

      $categories = $this->userClient->get(config('userconfig.ENDPOINTS.HOME.ALL_CATEGORY'), []);   //categories api

      $userNearStore = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.NEARBY'), ['longitude' => session()->get('userdetail')->lng, 'latitude' => session()->get('userdetail')->lat]);   //nearby api

      $params = [
        'longitude' => session()->get('userdetail')->lng,
        'latitude' => session()->get('userdetail')->lat,
        'is_trending' => 1,
        'unique' => 'product_id',
        'sorting_id' => 5,
      ];

      $trendingCategory = $this->userClient->post(config('userconfig.ENDPOINTS.HOME.TRENDING_CATEGORY'), $params);  //trending product by category
      $Products = empty($trendingCategory['response']['data']['data']) ? [] : $trendingCategory['response']['data']['data'];

      $allProduct = array_reduce($Products, function (array $accumulator, array $element) {
        $accumulator[$element['category_name']][] = $element;
        return $accumulator;
      }, []);

      $addBookMark = config('userconfig.ENDPOINTS.BOOKMARK.ADD');
      $removeBookMark = config('userconfig.ENDPOINTS.BOOKMARK.REMOVE');
      $addWishList = config('userconfig.ENDPOINTS.HOME.ADD_WISH_LIST');
      $removeWishList = config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST');
      return view(
        'User::home.home',
        [
          'trendingProduct' => $trendingProduct['response']['data'],
          'categories' => $categories['response'],
          'userNearStore' => $userNearStore['response']['data'],
          'trendingCategory' => $trendingCategory['response']['data'],
          'token' => $this->userClient->header['Authorization'],
          'categoryProduct' => $allProduct,
          'query' => $query,
          'addBookMark' => $addBookMark,
          'removeBookMark' => $removeBookMark,
          'addWishList' => $addWishList,
          'removewishlist' => $removeWishList,

        ]
      );
    } catch (Exception $e) {
      CommonHelper::handleException($e);
    }
  }




  /**
   * globalSearch
   * @return : application/html
   */

  public function globalSearch(Request $request)
  {
    try {

      $params = [
        'search_type' => $request->search_type,
        'search' => $request->search,
        'latitude' => $request->lat,
        'longitude' => $request->lng,
        'pagesize' => config('constants.GLOBAL_PAGINATE'),
        'page' => $request->page
      ];

      $globalSearch = $this->userClient->post(config('userconfig.ENDPOINTS.GLOBAL_SEARCH'), $params);   //global search api

      $reponse = [
        'code' => Response::HTTP_OK,
        'message' => trans('User::home.success'),
        'data' => $globalSearch['response']['data'],
      ];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($reponse);
  }


  /**
   * saveSearch fucntion is used to save recent searched data via api
   * @request : request
   * @return : success
   */
  public function saveSearch(Request $request)
  {
    $response = [
      'code' => Response::HTTP_OK,
      'message' => trans('User::home.success'),
    ];
    try {
      $params = [
        "term"          => $request->term,
        "searched_type" => $request->searched_type,
        "searched_id"   => $request->searched_id,
        "longitude"     => $request->longitude,
        "latitude"      => $request->latitude
      ];

      $saveGlobalSearch = $this->userClient->post(config('userconfig.ENDPOINTS.SAVE_GLOBAL_SEARCH'), $params);   //save global search data api

      $response['data'] = $saveGlobalSearch['response']['data']['data'];
    } catch (\Exception $e) {
      return CommonHelper::catchException($e);
    }
    return response()->json($response);
  }

  /**
   * showMobileRegistration
   * @return : application/html
   */

  public function showMobileRegistration()
  {
    return view('User::register.mobile');
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
        'phone' => 'required|unique:users,phone_number',
      ];

      /*
       |
       | define validation messages
       |
       */

      $messages = [
        'phone.unique' => trans('User::home.phone_unique'),
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
      $val = rand(1000, 9999);
      $otp = (config('constants.SMS_ENABLE')) ? $val : config('constants.BY_PASS_OTP'); //check otp if bypass or random
      $phone = $request->get('phone');
      $phone_code = $request->get('phone_code');
      $full_phone = $request->get('full_phone');
      $sms = [];
      $sms['otp'] = hash('sha256', $otp);
      $sms['phone'] = $phone;
      $sms['phone_code'] = $phone_code;
      $sms['full_phone'] = $full_phone;
      // $flag = $this->sendOTP($full_phone, $otp);
      // if (!$flag) {
      //   throw new Exception(trans('User::home.failed_to_send_otp'), Response::HTTP_UNPROCESSABLE_ENTITY);
      // }
      return redirect()->route('users.show.mobile.otp.verification.page', ['params' => base64_encode(serialize($sms))]);
    } catch (\Exception $e) {
      CommonHelper::handleException($e);
    }
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
   * @desc used for the verification of email
   */
  public function verifyEmail(Request $request)
  {
    try {
      $token = decrypt($request->token);

      if (now() > $token['time']) {
        throw new Exception(trans('User::home.time_expired'), Response::HTTP_FORBIDDEN);
      }

      $email = $token['email'];
      $user =  User::where('email_verified_token', $request->token)->exists();

      if (!$user) {

        throw new Exception(trans('User::home.user_not_found'), Response::HTTP_NOT_FOUND);
      }

      $user = User::where('email', $email)->first();
      $user->email_verified_at = config('constants.DEFAULT_DB_DATE_TIME_FORMAT');
      $user->save();
      return view('User::template.email_verify');
    } catch (Exception $e) {
      CommonHelper::handleException($e);
    }
  }

  /**
   * showBusinessNamePage
   * @param : null
   * @return : application/html
   */

  public function showAgeVerificationPage()
  {
    $user = Auth::guard('users')->user();
    $id = Auth::guard("users")->user()->id;
    $data = User::where('id', $id)->select(['dob', 'is_proof_completed'])->first();
    $useAgeProof = UserProof::where(['user_id' => $id, 'type' => config('constants.TYPE.AGE_PROOF')])->first();
    $useMedicalProof = UserProof::where(['user_id' => $id, 'type' => config('constants.TYPE.MEDICAL_PROOF')])->first();

    return view('User::dashboard.age_verification', compact('useAgeProof', 'useMedicalProof', 'data'));
  }

  /**
   * storeDocumentProof
   * @param : null
   * @return : application/html
   *
   */

  public function userDocumentProof(Request $request)
  {


    $dt = new Carbon();
    $before = $dt->subYears(21)->format('Y-m-d');

    $rules = [
      'file_input_age' => 'required',
      'year' => 'required',
      'day'  => 'required',
      'month' => 'required',
      'date_of_birth' => 'required|date|before:' . $before
    ];

    $validation = Validator::make($request->all(), $rules);

    if ($validation->fails()) {

      return Redirect::back()->with('errors', $validation->errors())->withInput();
    }

    try {
      $date = $request->year . '-' . $request->month . '-' . $request->day;




      DB::beginTransaction();
      $id = Auth::guard("users")->user()->id;
      if ($request->get('file_input_age')) {    //create or update
        $file_name = (is_null($request->get('age_document_proof'))) ? $request->get('hidden_age_file_name') : $request->get('age_document_proof');
        UserProof::updateOrCreate(
          [
            'user_id' => $id,
            'type' => config('constants.TYPE.AGE_PROOF'),
          ],
          [
            'file_url' => $request->get('file_input_age'),
            'file_name' => $file_name,
          ]
        );
      }
      if ($request->get('file_input_medical')) {
        $file_name = (is_null($request->get('medical_document_proof'))) ? $request->get('hidden_medical_file_name') : $request->get('medical_document_proof');

        UserProof::updateOrCreate(  //create or update
          [
            'user_id' => $id,
            'type' => config('constants.TYPE.MEDICAL_PROOF'),
          ],
          [
            'file_url' => $request->get('file_input_medical'),
            'file_name' => $file_name,
          ]
        );
      }

      /*
      |
      | update user status as profile complete and its dob field
      |
      */

      $date = $request->year . '-' . $request->month . '-' . $request->day;
      $dob = date_format(date_create($date), "Y-m-d");
      $user = User::find($id);
      $user->dob = $dob;
      $user->is_proof_completed = config('constants.YES');
      $user->save();

      DB::commit();

      $response = ['code' => Response::HTTP_OK, 'message' => trans('User::home.document_updated_successfully')];
    } catch (Exception $e) {
      DB::rollBack();
      CommonHelper::handleException($e);
    }

    return redirect()->route('users.dashboard')->with('success', $response);
  }


  /**
   * showDeliveryLocation
   * @param : null
   * @return : application/html
   */

  public function showDeliveryLocation()
  {
    $user = Auth::guard("users")->user();
    $id = Auth::guard("users")->user()->id;
    $data = UserDetail::where('user_id', $id)->first();
    return view('User::dashboard.location', compact('data'));
  }

  /**
   * storeDetails
   * @param : null
   * @return : application/html
   */

  public function userLocationDetails(Request $request)
  {
    $rules = [
      'address' => 'required',
      'lat' => 'required',
      'lng' => 'required',
    ];

    $validation = Validator::make($request->all(), $rules);

    if ($validation->fails()) {
      return Redirect::back()->with('errors', $validation->errors())->withInput();
    }


    try {
      DB::beginTransaction();
      $userID = Auth::guard('users')->user()->id;

      UserDetail::updateOrCreate(
        ['user_id' => $userID],
        [
          'formatted_address' => $request->address,
          'city' => $request->locality ?? null,
          'state' => $request->administrative_area_level_1 ?? null,
          'country' => $request->country ?? null,
          'lat' => $request->lat,
          'lng' => $request->lng,
          'zipcode' => $request->postal_code ?? null,
          'ip' => $request->ip ?? null,
          'user_id' => $userID,
        ]
      );

      $user = User::find($userID);
      $user->is_profile_complete = config('constants.YES');
      $user->location_updated_at = config('constants.DEFAULT_DB_DATE_TIME_FORMAT');
      $user->personal_address = $request->address ?? '';
      $user->lat = $request->lat ?? '';
      $user->lng = $request->lng ?? '';
      if (!$user->save()) {
        throw new Exception(trans('User::home.error'), Response::HTTP_NOT_FOUND);
      }
    } catch (Exception $e) {
      DB::rollBack();
      CommonHelper::handleException($e);
    }
    DB::commit();
    return redirect()->route('users.dashboard');
  }
}
