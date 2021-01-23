<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class CheckUserStatus
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
        if(!Auth::guard($guard)->check())
        {
            // if user not authenticated
            return redirect('/users');
        }

        $user       = Auth::guard($guard)->user();
        $response   = $next($request);

        if ($user->is_proof_completed == 0) 
        { 
            //if proof is not uploaded
            return redirect()->route('users.age.verification');
        }
    
        if (is_null($user->location_updated_at)) 
        {     
            //if delivery location is not updated
            return redirect()->route('user.show.delivery.page');
        }
  
        if($user->status != config('constants.STATUS.ACTIVE'))
        {
            // if user blocked by admin
            Auth::guard('users')->logout();
            return redirect()->route('users.login')->with(['message'=>config('constants.USER_SERVICE_UNAVAILABLE')]);
    
        }
        return $response;
    }
}
