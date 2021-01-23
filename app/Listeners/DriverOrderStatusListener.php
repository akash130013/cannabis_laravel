<?php

namespace App\Listeners;

use App\Enums\NotificationType;
use App\Events\DriverOrderStatusEvent;
use App\Helpers\CommonHelper;
use App\Models\Order;
use App\Models\UserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DriverOrderStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param DriverOrderStatusEvent $event
     * @return void
     */
    public function handle(DriverOrderStatusEvent $event)
    {
        $order = Order::where('order_uid', $event->orderUid)->first();
        if (!$order) {
            return;
        }

        if (!isset($order->distributors->first()->id)) {
            return;
        }
        $notification        = new \stdClass();
        $notification->title = $event->title;
        $notification->notify_type    = $event->notify_type;
        $notification->description    = $event->description;

        $notification->notify_type_id = $event->orderUid;
        $notification->url            = "";
        $param                        = [
            'user_id'   => $order->distributors->first()->id,
            'user_type' => config('constants.userType.driver')
        ];

        UserNotification::create([
            'user_id'        => $order->distributors->first()->id,
            'user_type'      => config('constants.userType.driver'),
            'title'          => $event->title,
            'description'    => $event->description,
            'notify_type'    => $event->notify_type,
            'notify_type_id' => $event->orderUid,
        ]);

        CommonHelper::sendPushNotification($notification, $param);
    }
}
