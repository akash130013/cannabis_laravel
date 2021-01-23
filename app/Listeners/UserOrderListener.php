<?php

namespace App\Listeners;

use App\Events\UserOrderEvent;
use App\Helpers\CommonHelper;
use App\Models\Order;
use App\Models\UserNotification;

class UserOrderListener
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
     * @param UserOrderEvent $event
     * @return void
     */
    public function handle(UserOrderEvent $event)
    {


        $order = Order::where('order_uid', $event->orderUid)->first();
        if (!$order) {
            return;
        }

        $notification        = new \stdClass();
        $notification->title = "Order Updated " . $event->orderUid . '' . now();

        $notification->notify_type    = $event->type; // NotificationType::Driver_Order_cancelled;
        $notification->notify_type_id = $event->orderUid;
        $notification->description    = $event->description;
        $notification->url            = "";
        $param                        = [
            'user_id'   => $event->userId,
            'user_type' => $event->userType
        ];

        UserNotification::create([
            'user_id'        => $event->userId,
            'user_type'      => $event->userType,
            'title'          => $event->title,
            'description'    => $event->description,
            'notify_type'    => $event->type,
            'notify_type_id' => $event->orderUid,
        ]);

        CommonHelper::sendPushNotification($notification, $param);

    }
}
