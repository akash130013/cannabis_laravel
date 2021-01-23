<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckAge
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
        $user=Auth::guard('users')->user();
        
        
        if ($user->is_proof_completed == 1 && !is_null($user->location_updated_at)) { 
          return redirect()->route('users.dashboard');
        }
        
        return $next($request);
    }
}
