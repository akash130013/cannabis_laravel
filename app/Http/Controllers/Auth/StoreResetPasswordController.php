<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Password;
use Auth;
use DB;
use Hash;

class StoreResetPasswordController extends Controller
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
    protected $redirectTo = '/store/logout';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        // Auth::guard('store')->logout();
        $this->middleware('guest:store');
    }

    public function showResetForm(Request $request, $token = null) {
       
        $email=$this->get_user_by_token($token);
       
        return view('auth.passwords.store-reset')
            ->with(['token' => $token, 'email' => $email]
            );
    }

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
        return Auth::guard('store');
    }

    //defining our password broker function
    protected function broker() {
        return Password::broker('store');
    }
}