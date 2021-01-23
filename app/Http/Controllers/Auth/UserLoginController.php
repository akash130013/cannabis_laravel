<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;



class UserLoginController extends Controller
{

    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {

        return view('auth.user-login');
    }

    /**
     * showHomePage
     *  @return \Illuminate\Http\Response   
     * 
     */

    public function showHomePage(Request $request)
    {
        return view('auth.user-home-page');
    }

    protected function guard()
    {
        return Auth::guard('users');
    }

    use AuthenticatesUsers {
        logout as performlogout;
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:users')->except('logout');
    }

    public function logout(Request $request)
    {
        Auth::guard('users')->logout();

        return redirect()->route('users.login');
    }
   
    /**
       * Get the needed authorization credentials from the request.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return array
       */
      protected function credentials(Request $request)
      {
        $credentials = [];
        
         $phoneNumber=$request->get('contact_number');
         $country_code=$request->get('country_code');
         $phoneNumber  = preg_replace("/^\+?{$country_code}/", '',$phoneNumber);   //to remove country code and 0 from input
         
        if(is_numeric($phoneNumber)){
           $credentials =  ['phone_number'=>$phoneNumber,'password'=>$request->get('password')];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $credentials =  ['email' => $request->get('email'), 'password'=>$request->get('password')];
        }else {
            $credentials =  ['name' => $request->get('email'), 'password'=>$request->get('password')];
        }
         
        return $credentials;
      }

}
