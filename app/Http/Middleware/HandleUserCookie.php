<?php

namespace App\Http\Middleware;

use Closure;

class HandleUserCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {       
      
        
       
        if( empty($_COOKIE['is_age_confirmed']) ||  !boolval($_COOKIE['is_age_confirmed'])) {
           
            return redirect()->route('users.home.page');
        }
        
        return $next($request);
    }
}
