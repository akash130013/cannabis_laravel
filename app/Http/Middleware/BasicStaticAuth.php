<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class BasicStaticAuth
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
        

        if ($request->headers->has('Authorization')) {
            $authStr = base64_decode(trim(Str::after($request->header('Authorization'), 'Basic')));
            if ( $authStr == config('constants.basic_auth_login').':'.config('constants.basic_auth_password')){
                return $next($request);
            }

        }

        return response()->jsend_error(new \Exception("error basic auth failure"), $message = null, $code = 407);

    }
}
