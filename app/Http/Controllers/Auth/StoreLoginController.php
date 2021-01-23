<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class StoreLoginController extends Controller
{
   
    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
       
        return view('auth.store-login');
    }
    protected function guard(){
        return Auth::guard('store');
    }
    
    use AuthenticatesUsers {
        logout as performlogout;
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/store/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:store')->except('logout');
    }

    public function logout(Request $request)
    {
        
        //$this->performLogout($request);
        Auth::guard('store')->logout();
        
        return redirect('store');
    }


}
