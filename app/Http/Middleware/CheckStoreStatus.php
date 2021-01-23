<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStoreStatus
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
        
        if(!Auth::guard('store')->check())
        {
            return redirect('/store');
        }
        $response = $next($request);
        if(!Auth::guard($guard)->user()->is_profile_complete 
            && Auth::guard($guard)->user()->admin_action !=  config('constants.STATUS.APPROVE'))
        {
            return redirect('/store');
        }
        return $response;
    }
}
