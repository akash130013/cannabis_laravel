<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Modules\User\Models\UserDeliveryLocation;
use App\Modules\User\Models\UserProof;
use App\Rules\MatchOldPassword;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ContactUsRequest;
use App\Notifications\SendSignoutOtpNotification;
use App\Helpers\TwilioService;
use App\Models\ContactQuery;
use App\Models\StaticPage;


class SettingController extends Controller
{

    const AGE_PROOF = "1";

    const MEDICAL_PROOF = "2";


    /**
     * indexo
     * @param : null
     * @return : application/html
     */

    public function index(Request $request)
    {
        $userId = Auth::guard('users')->user()->id;
        $ageProof = UserProof::where('user_id', $userId)->where('type', self::AGE_PROOF)->first();
        $medicalProof = UserProof::where('user_id', $userId)->where('type', self::MEDICAL_PROOF)->first();

        return view('User::settings.index', compact('ageProof', 'medicalProof'));
    }

    /**
     * editAccountInfo
     * @param : null
     * @return : application/html
     */

    public function editAccountInfo()
    {
        $userId = Auth::guard('users')->user()->id;
        $ageProof = UserProof::where('user_id', $userId)->where('type', self::AGE_PROOF)->first();
        $medicalProof = UserProof::where('user_id', $userId)->where('type', self::MEDICAL_PROOF)->first();
        return view('User::settings.edit-setting', compact('ageProof', 'medicalProof'));
    }

    /**
     * updateAccountInfo
     * @param : request 
     * @return : application/html
     */

    public function updateAccountInfo(Request $request)
    {
        /*
            |
            | define validation rules
            |
            */

        $rules = [
            'username' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'file_name_age' => 'required',
            'file_input_age' => 'required',
        ];


        /*
            |
            | run validation rules.
            |
            */

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->with('errors', $validation->errors());
        }

        try {

            $userId = Auth::guard('users')->user()->id;
            /*
                |
                | update user info
                |
                */

            $userObj                    = User::find($userId);
            $userObj->name              = $request->get('username');
            $userObj->personal_address  = $request->get('address');
            $userObj->lat               = $request->get('lat');
            $userObj->lng               = $request->get('lng');
            $userObj->save();

            /*
                |
                | update age proof
                |
                */

            if ($request->get('file_input_age')) {    //create or update
                $file_name = (is_null($request->get('age_document_proof'))) ? $request->get('hidden_age_file_name') : $request->get('age_document_proof');
                UserProof::updateOrCreate(
                    [
                        'user_id' => $userId,
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
                        'user_id' => $userId,
                        'type' => config('constants.TYPE.MEDICAL_PROOF'),
                    ],
                    [
                        'file_url' => $request->get('file_input_medical'),
                        'file_name' => $file_name,
                    ]
                );
            }

            $reponse = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.profile_updated')
            ];
        } catch (Exception $e) {
            return CommonHelper::handleException($e);
        }
        return redirect()->route('user.show.setting.page')->with('success', $reponse);
    }
    /**
     * showChangePassword
     * @param : null
     * @return : application/html
     */

    public function showChangePassword()
    {
        return view('User::settings.change-password');
    }

    /**
     * updateMobile
     * @param : Request object
     * @return : application/html
     */

    public function updateMobile(Request $request)
    {

        /*
        |
        | define validation rules
        |
        */
        $rules = [
            'phone' => 'required',
            'dialcode' => 'required',
            'contact_number' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return Redirect::back()->with('errors', $validation->errors());
        }


        try {

            /*
            |
            | validate if number aloready exits or not
            |
            */
            $phoneNumber =  $request->get('contact_number');

            /*
            |
            |   update user info
            | 
            */
            $country_code = $request->get('dialcode');
            $phoneNumber  = preg_replace("/^\+?{$country_code}/", '', $phoneNumber);

            if (User::where(['phone_number' => $phoneNumber, 'deleted_at' => null])->exists()) {  // user found

                throw new Exception(trans('User::home.existing_number'), Response::HTTP_NOT_IMPLEMENTED);
            }


            $user = User::find(Auth::guard('users')->user()->id);
            $user->country_code = '+' . $request->get('dialcode');
            $user->phone_number =  $phoneNumber;
            $user->save();

            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.mobile_updated')
            ];
        } catch (Exception $e) {
            return CommonHelper::handleException($e);
        }
        return Redirect::back()->with('success', $response);
    }



    /**
     * updateMobile
     * @param : Request object
     * @return : application/html
     */

    public function updateEmail(Request $request)
    {

        /*
        |
        | define validation rules
        |
        */
        $rules = [
            'email' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return Redirect::back()->with('errors', $validation->errors());
        }


        try {

            /*
            |
            | validate if number aloready exits or not
            |
            */
            $email =  $request->get('email');

            /*
            |
            |   update user info
            | 
            */

            if (!$request->has('verify')) {   //this will check if request is coming for the verify or change email
                if (User::where(['email' => $email, 'deleted_at' => null])->exists()) {  // user found

                    throw new Exception(trans('User::home.existing_email'), Response::HTTP_NOT_IMPLEMENTED);
                }
            }

            $user = User::find(Auth::guard('users')->user()->id);
            $user->email = $email;
            $user->email_verified_at = config('constants.DEFAULT_DB_DATE_TIME_FORMAT');

            $user->save();

            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.email_updated')
            ];
        } catch (Exception $e) {
            return CommonHelper::handleException($e);
        }

        return Redirect::back()->with('success', $response);
    }

    /**
     * updatePassword
     */

    public function updatePassword(Request $request)
    {
        /*
        |
        | define validation rules
        |
        */


        $rules = [
            'current_password' => ['required', new MatchOldPassword('users')],
            'password' => ['required', 'not_in:' . $request->current_password],
            'new_confirm_password' => ['same:password'],
        ];

        $message = [
            'password.not_in' => "Current password and New password can not same"
        ];

        $validation = Validator::make($request->all(), $rules, $message);

        if ($validation->fails()) {

            return Redirect::back()->with('errors', $validation->errors());
        }


        try {

            User::find(auth()->guard('users')->user()->id)->update(['password' => Hash::make($request->password)]);

            $response = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.password_updated')
            ];
        } catch (Exception $e) {
            return CommonHelper::handleException($e);
        }

        return Redirect::back()->with('success', $response);
    }

    /**
     * showChangePhoneNumber
     */

    public function showChangePhoneNumber()
    {
        return view('User::settings.change-mobile');
    }

    /**
     * showChangeAddress
     * @param : null
     * @return : application/html
     */

    public function showChangeAddress()
    {
        $userId = Auth::guard('users')->user()->id;
        $DeliveryLocations = UserDeliveryLocation::where('user_id', $userId)->get();
        return view('User::settings.change-address', compact('DeliveryLocations'));
    }

    /**
     * addDeliveryAddress
     * @param : null
     * @return : application/html
     */

    public function addDeliveryAddress(Request $request)
    {

        /*
        |
        | define validation rules
        |
        */

        $rules = [
            'username' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'administrative_area_level_1' => 'required',
            'locality' => 'required',
            'postal_code' => 'required',
            'address_type_val' => 'required',
        ];


        /*
        |
        | run validation rules
        |
        */

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->with('errors', $validation->errors());
        }

        $isCartRedirect = $request->get('is_cart_redirect', '');

        try {
            $userId = Auth::guard('users')->user()->id;

            $deliveryAddress = new UserDeliveryLocation;
            $deliveryAddress->user_id = $userId;
            $deliveryAddress->name = $request->get('username');
            $deliveryAddress->mobile = $request->get('contact_number');
            $deliveryAddress->address = $request->get('houseno', '');
            $deliveryAddress->formatted_address = $request->get('address');
            $deliveryAddress->city = $request->get('locality');
            $deliveryAddress->state = $request->get('administrative_area_level_1');
            $deliveryAddress->zipcode = $request->get('postal_code');
            $deliveryAddress->country = is_null($request->get('country')) ? "" : $request->get('country', '');
            $deliveryAddress->lat = is_null($request->get('lat')) ? 0.00000 : $request->get('lat', '');
            $deliveryAddress->lng = is_null($request->get('lng')) ? 0.00000 : $request->get('lng', '');
            $deliveryAddress->address_type = $request->get('address_type_val', 'Home');

            $deliveryAddress->save();

            $http_response_header = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.add_delivery_location')
            ];
        } catch (Exception $e) {
            return CommonHelper::handleException($e);
        }

        return $isCartRedirect ? redirect()->route('user.checkout.delivery.address') : Redirect::back()->with('success', $http_response_header);
    }


    /**
     * updateAddress
     * @param : Request
     * @return : previous page with success or failure code
     */

    public function updateAddress(Request $request)
    {

        /*
        |
        | define validation rules
        |
        */

        $rules = [
            'username' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'delivery_id' => 'required',
            'address_type_val' => 'required',
        ];

        /*
        |
        | run validation rules
        |
        */

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->with('errors', $validation->errors());
        }

        try {
            $deliveryID = $request->get('delivery_id');

            $deliveryAddress = UserDeliveryLocation::find($deliveryID);
            $deliveryAddress->name = $request->get('username');
            $deliveryAddress->mobile = $request->get('contact_number_edit');
            $deliveryAddress->address = $request->get('houseno', '');
            $deliveryAddress->formatted_address = $request->get('address');
            $deliveryAddress->city = $request->get('city');
            $deliveryAddress->state = $request->get('state');
            $deliveryAddress->zipcode = $request->get('postal_code');
            $deliveryAddress->country = $request->get('country', '');
            $deliveryAddress->lat = $request->get('lat', '');
            $deliveryAddress->lng = $request->get('lng', '');
            $deliveryAddress->address_type = $request->get('address_type_val', 'Home');

            $deliveryAddress->save();

            $http_response_header = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.update_delivery_location')
            ];
        } catch (Exception $e) {
            return CommonHelper::handleException($e);
        }

        return Redirect::back()->with('success', $http_response_header);
    }

    /**
     * showDeliveryLocationPage
     * @param : editId
     * @return : application/json
     */

    public function showDeliveryLocationPage(Request $request)
    {
        $deliveryId = $request->get('id');

        $deliveryAddress = UserDeliveryLocation::find($deliveryId);

        $html = view('User::settings.edit-delivery', compact('deliveryAddress'))->render();

        return response()->json(['html' => $html, 'code' => Response::HTTP_OK]);
    }

    /**
     * deleteAddress
     * @param : deletedId
     * @return : application/html with success message
     */

    public function deleteAddress(Request $request)
    {
        try {
            $id  = $request->get('id');

            if (empty($id)) {
                throw new Exception(trans('User::home.invalid_id'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $deliveryAddress = UserDeliveryLocation::find($id);

            if (is_null($deliveryAddress)) {
                throw new Exception(trans('User::home.unable_to_delete_record_not_found'), Response::HTTP_NOT_FOUND);
            }

            $deliveryAddress->delete();

            $reponse = [
                'code' => Response::HTTP_OK,
                'message' => trans('User::home.address_deleted')
            ];
        } catch (Exception $e) {
            return CommonHelper::handleException($e);
        }

        return Redirect::back()->with('success', $reponse);
    }


    /**
     * showTermsAndConditions
     * @param : null
     * @return : application/html
     */

    public function showTermsAndConditions()
    {
        $data = StaticPage::where('slug', 'terms-conditions')
            ->where('panel', 'user')
            ->first();
        return view('User::settings.terms-condition', compact('data'));
    }

    /**
     * showPrivacyPolicy
     * @param : null
     * @return : application/html
     */

    public function showPrivacyPolicy()
    {
        $data = StaticPage::where('slug', 'privacy-policy')
            ->where('panel', 'user')
            ->first();
        return view('User::settings.privacy-policy', compact('data'));
    }
    /**
     * showHelpPage
     * @param : null
     * @return : application/html
     */

    public function showHelpPage()
    {
        // $data=StaticPage::where('slug','contact-us')->first(); 
        return view('User::settings.help');
    }


    /**
     * showContactUsPage
     * @param : null
     * @return : application/html
     */

    public function showContactUsPage()
    {
        $data = StaticPage::where('slug', 'contact-us')
            ->where('panel', 'user')->first();
        return view('User::settings.contact-us', compact('data'));
    }

    /**
     * contactUs
     * @param : null
     * @return : response array with failure or success
     */

    public function contactUs(ContactUsRequest $request)
    {
        try {
            $data = $request->except('_token');
            $contact = ContactQuery::create($data);
            info($contact);
            $http_response_header = ['code' => Response::HTTP_OK, 'message' => trans('User::home.contact_us_saved')];
        } catch (Exception $e) {
            info($e);
            return CommonHelper::handleException($e);
        }

        return Redirect::route('users.login')->with('success', $http_response_header);
    }

    /**
     * showFaqPage
     * @param : null
     * @return : application/html
     */

    public function showFaqPage()
    {
        $data = StaticPage::where('slug', 'faq')
            ->where('panel', 'user')->first();
        return view('User::settings.faq', compact('data'));
    }

    /**
     * showFaqPage
     * @param : null
     * @return : application/html
     */

    public function showAboutUsPage()
    {
        $data = StaticPage::where('slug', 'about-us')
            ->where('panel', 'user')->first();
        return view('User::settings.about-us', compact('data'));
    }


    /**
     * ResentMobileOTPcode
     * @param : mobile number 
     * @return : application/json
     */

    public function mobileOTPcode(Request $request, TwilioService $twilio)
    {

        try {
            $phoneNumber = $request->phone;
            $country_code = $request->dialCode;

            $phoneNumber  = preg_replace("/^\+?{$country_code}/", '', $phoneNumber);

            if (User::where('phone_number', '=', $phoneNumber)->exists()) {  // user found
                throw new Exception(trans('User::home.existing_number'), Response::HTTP_NOT_IMPLEMENTED);
            }


            $otp = mt_rand(1000, 9999);

            $sid = $twilio->sms($request->phone, $otp, $country_code, $phoneNumber);

            $http_response_header = ['code' => Response::HTTP_OK, 'sid' => $sid, 'messages' => trans('Store::home.phone_otp_send'), 'hash' => hash('sha256', $otp)];
        } catch (\Exception $e) {
            return CommonHelper::catchException($e);
        }
        return response()->json($http_response_header);
    }


    /**
     * @desc used for the send email otp
     */
    public function sendEmailOTP(Request $request)
    {

        try {

            $rules = [
                'email' => 'required|email|unique:users',
            ];

            /*
        |
        | run validation rules
        |
        */

            $validation = Validator::make($request->all(), $rules);

            if ($validation->fails()) {

                throw new Exception($validation->errors()->first(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $otp = mt_rand(1000, 9999);  //send otp

            $user = new User();
            $user->email = $request->email;
            $user->notify(new SendSignoutOtpNotification($otp));
            $http_response_header = ['code' => Response::HTTP_OK, 'messages' => trans('Store::home.email_otp_send'), 'hash' => hash('sha256', $otp)];
        } catch (\Exception $e) {
            return CommonHelper::catchException($e);
        }
        return response()->json($http_response_header);
    }




    /**
     * @desc used for the send email otp
     */
    public function verifyEmail(Request $request)
    {

        try {

            $rules = [
                'email' => 'required|email',
            ];

            /*
        |
        | run validation rules
        |
        */

            $validation = Validator::make($request->all(), $rules);

            if ($validation->fails()) {

                throw new Exception($validation->errors()->first(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $otp = mt_rand(1000, 9999);  //send otp

            $user = new User();
            $user->email = $request->email;
            $user->notify(new SendSignoutOtpNotification($otp));
            $http_response_header = ['code' => Response::HTTP_OK, 'messages' => trans('Store::home.email_otp_send'), 'hash' => hash('sha256', $otp)];
        } catch (\Exception $e) {
            return CommonHelper::catchException($e);
        }
        return response()->json($http_response_header);
    }

    /**
     * upload profile pic
     * @request : $request
     * @return : application/json
     */
    public function uploadProfilePic(Request $request)
    {
        try {
            $userId = Auth::guard('users')->user()->id;
            $user = User::find($userId);
            $data = [
                'profile_pic' => $request->profilePic,
            ];
            $user->update($data);
            $response = ['code' => Response::HTTP_OK, 'message' => trans('User::home.user_profile_updated')];
        } catch (Exception $e) {
            return CommonHelper::catchException($e);
        }

        return response()->json($response);
    }

    /**
     * showExteriorHelpPage
     * @param : null
     * @return : application/html 
     */

    public function showExteriorHelpPage()
    {
        $data = StaticPage::where('slug', 'help')
            ->where('panel', 'user')->first();
        return view('User::settings.exterior-static-page.help', compact('data'));
    }


    /**
     * showExteriorHelpPage
     * @param : null
     * @return : application/html 
     */

    public function showExteriorContactPage()
    {
        $data = StaticPage::where('slug', 'contact-us')
            ->where('panel', 'user')->first();
        return view('User::settings.exterior-static-page.contact-us', compact('data'));
    }


    /**
     * showExteriorAboutPage
     * @param : null
     * @return : application/html 
     */

    public function showExteriorAboutPage()
    {

        $data = StaticPage::where('slug', 'about-us')
            ->where('panel', 'user')->first();
        return view('User::settings.exterior-static-page.about-us', compact('data'));
    }

    /**
     * showExteriorPrivacyPolicy
     * @param : null
     * @return : application/html 
     */

    public function showExteriorPrivacyPolicy()
    {
        $data = StaticPage::where('slug', 'privacy-policy')
            ->where('panel', 'user')->first();
        return view('User::settings.exterior-static-page.privacy-policy', compact('data'));
    }

    /**
     * showExteriorPrivacyPolicy
     * @param : null
     * @return : application/html 
     */

    public function showExteriorTermsAndConditions()
    {
        $data = StaticPage::where('slug', 'terms-conditions')
            ->where('panel', 'user')->first();
        return view('User::settings.exterior-static-page.terms-condition', compact('data'));
    }
}
