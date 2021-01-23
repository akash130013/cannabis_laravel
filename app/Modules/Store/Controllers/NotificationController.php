<?php


namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StoreNotifications;

class NotificationController extends Controller
{
    /**
     * index
     * @param : null
     * @return : application/html
     */

    public function index()
    {
        $storeId = Auth::guard('store')->user()->id;
        $storeNotification =  StoreNotifications::where('store_id',$storeId);
        $storeNotification->update(['is_read'=>true]);
        $notifications = $storeNotification->latest()->paginate(config('PAGINATE'));
       
        return view('Store::notification.index',compact('notifications'));

    }

    /***
     * To get Unread notification count of store notification
     * @param : null
     * @return : application/integer
     */
    public function unreadNotificationCount()
    {
        $storeId = Auth::guard('store')->user()->id;
        $notificationCount = StoreNotifications::where('store_id',$storeId)->where('is_read',false)->count();
        return $notificationCount;
    }


}
