<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Password;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Response;


class UserResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('guest:users');
    }

    public function showResetForm(Request $request, $token = null) {
     
        try{
        $token = unserialize(base64_decode($token));
      
        // $email=$this->get_user_by_token($token);
         $user=User::where('phone_number',$token['phone'])->first();
       
        $token=null;
        return view('auth.passwords.user-reset')
            ->with(['email' => encrypt($user->email)]
            );
        }catch(Exception $e){
            $errors = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
            Log::error(trans('User::home.error_processing_request'), $errors);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    }


    /**
     * @desc user get token
     */
    function get_user_by_token($token){
        $records =  DB::table('password_resets')->get();
        foreach ($records as $record) {
            if (Hash::check($token, $record->token) ) {
               return $record->email;
            }
        }
    }

    protected function guard()
    {
        return Auth::guard('users');
    }

    //defining our password broker function
    protected function broker() {
        return Password::broker('users');
    }
}