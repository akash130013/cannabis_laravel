<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {
        

        $response = $next($request);
        //If the status is not approved redirect to login 
        if(Auth::guard($guard)->check())
        {

                        switch ($guard) 
                        {
                            case 'store':   $is_authorized = true;
                                            if(Auth::guard($guard)->user()->status != 'active')
                                            {
                                                $message = ['message'=>config('constants.USER_SERVICE_UNAVAILABLE')];
                                                $is_authorized = false;
                                            }
                                            // else if(Auth::guard($guard)->user()->is_profile_complete && Auth::guard($guard)->user()->admin_action == 'pending')
                                            // {
                                            //     $message = ['account-info'=>'Your account is under pending approval, please wait..'];
                                            //     $is_authorized = false;
                                            // }
                                            if(Auth::guard($guard)->user()->is_profile_complete && Auth::guard($guard)->user()->admin_action == 'reject')
                                            {
                                                $message = ['message'=>config('constants.USER_SERVICE_UNAVAILABLE')];
                                                $is_authorized = false;
                                            }
                                            if(!$is_authorized)
                                            {
                                                Auth::guard('store')->logout();
                                                return redirect()->route('store.login')->with($message);
                                            }
                                            break;
                
                            case 'users':  if(Auth::guard($guard)->user()->status != config('constants.STATUS.ACTIVE'))
                                            {
                                                Auth::guard('users')->logout();
                                                return redirect()->route('users.login')->with(['message'=>config('constants.USER_SERVICE_UNAVAILABLE')]);
                                            }
                                             break;
                

                            default:
                            
                                break;
                        }
               
        } 
        
        return $response;
    }
}
