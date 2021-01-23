<?php

namespace App\Http\Middleware;
use App\Models\StoreNotifications;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Closure;

class RecentNotifications
{
    /**
     * 
     *  define notification limit constant
     * 
     */

    const NOTIFICATION_LIMIT = 3;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        

        $storeId = Auth::guard('store')->user()->id;

        $notifications = StoreNotifications::where('store_id',$storeId)->orderBy('created_at','DESC')->limit(self::NOTIFICATION_LIMIT)->get();

        Session::put('notificationList',$notifications);

        return $next($request);
    }
}
