<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $guard
     * @return mixed
     */

    protected function authenticate($request, array $guards)
	{
          
          if (empty($guards)) {
			$guards = [null];
          }
          // if($request->getHttpHost() == env('STORE_DOMAIN'))
          // {
          //      $guards = ['store'];
          // }
          // if($request->getHttpHost() == env('ADMIN_DOMAIN'))
          // {
          //      $guards = ['admin'];
          // }
          
		foreach ($guards as $guard) {
			if ($this->auth->guard($guard)->check()) {
				return $this->auth->shouldUse($guard);
			}
		}
          $guard = $guards[0];
		switch ($guard) {
               
            case 'admin':if (!Auth::guard($guard)->check()) {
                              $this->redirectTo('/admin');
                         }
                         break;

            case 'store': if (!Auth::guard($guard)->check()) {
                              $this->redirectTo('/store');
                         }
                         else if (Auth::guard($guard)->user()->status != config('constants.STATUS.ACTIVE')) {
                              $this->redirectTo('store.logout');
                         }

                         break;

            case 'users': if (!Auth::guard($guard)->check()) {
                              $this->redirectTo('/users');
                         }
                         else if (Auth::guard($guard)->user()->status != config('constants.STATUS.ACTIVE')) {
                              Auth::guard('users')->logout();
                              return redirect()->route('users.login')->with(['message'=>config('constants.USER_SERVICE_UNAVAILABLE')]);
                      
                         }

                         break;


            default:
                if (!Auth::guard($guard)->check()) {
                     $this->redirectTo('/users');
                }
                break;
        }

		throw new AuthenticationException(
			'Unauthenticated.', $guards, $this->redirectTo($request)
		);
    }
    
    
}