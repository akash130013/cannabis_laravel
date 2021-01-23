<?php

namespace App\Http\Middleware;

use Closure;
use App\Modules\User\Controllers\GuzzleUserClient;
use Symfony\Component\HttpFoundation\Response;

class ValidateAuthTokenResponse
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
        
        return $next($request);
    }
}
