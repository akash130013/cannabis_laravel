<?php

namespace App\Listeners;

use App\Events\NotifyStoreEvent;
use App\Helpers\CommonHelper;
use App\Models\Order;
use App\Models\StoreNotifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyStoreListener
{
    /**
     * @var StoreNotifications $storeNotifications
     * @var Order $order
     */
    protected $storeNotifications, $order;

    /**
     * Create the event listener.
     * @param StoreNotifications $storeNotifications
     * @param $order
     * @return void
     */
    public function __construct(Order $order, StoreNotifications $storeNotifications)
    {
        $this->storeNotifications = $storeNotifications;
        $this->order              = $order;
    }

    /**
     * Handle the event.
     * @param NotifyStoreEvent $event
     * @return void
     */
    public function handle(NotifyStoreEvent $event)
    {
        $order      = $this->order->where('order_uid', $event->orderUid)->first();
        $orderLabel = CommonHelper::getOrderStatusLabel($order->order_status);
        $payload    = [
            'order_uid'  => $event->orderUid,
            'store_id'   => $event->storeId,
            'type'       => $event->type,
            'order_type' => $orderLabel, //['ongoing', 'completed', 'upcoming']
//            'link'=> null ,

        ];
        $this->storeNotifications->Create([
            'title'       => $event->title,
            'description' => $event->description,
            'store_id'    => $event->storeId,
            'type'        => $event->type,
            'payload'     => $payload,
        ]);
    }
}
