<?php

namespace App\Listeners;

use App\Events\DistributorOrderPaymentReceivedEvent;
use App\Models\Order;
use App\Models\StoreCommision;
use App\Models\StoreEarning;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminEarningListener
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
     * @param DistributorOrderPaymentReceivedEvent $event
     * @return void
     */
    public function handle(DistributorOrderPaymentReceivedEvent $event)
    {
        $order = Order::where('order_uid', $event->orderUid)->first();
        if (!$order) {
            return;
        }
        $storeCommision = StoreCommision::where(['store_id' => $order->store_id, 'status' => 'active'])->first();
        if (!$storeCommision) {
            return;
        }

        $commission =  $order->net_amount* $storeCommision->commison_percentage * 0.01;
        StoreEarning::create([
            'order_id'       => $order->id,
            'order_uid'      => $order->order_uid,
            'store_id'       => $order->store_id,
            'net_amount'     => $order->net_amount,
            'commission'     => $commission,
            'payment_method' => $order->payment_method,
        ]);

    }
}
