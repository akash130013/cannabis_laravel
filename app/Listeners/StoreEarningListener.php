<?php

namespace App\Listeners;

use App\Events\StoreEarningEvent;
use App\Models\Order;
use App\Models\StoreCommision;
use App\Models\StoreEarning;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreEarningListener
{
    /**
     * @var Order
     * @var StoreCommision
     * @var StoreEarning
     */
    private $order, $storeCommission, $storeEarning;

    /**
     * Create the event listener.
     * @param Order $order
     * @param StoreCommision $storeCommission
     * @param StoreEarning $storeEarning
     * @return void
     */
    public function __construct(Order $order, StoreCommision $storeCommission, StoreEarning $storeEarning)
    {
        $this->order           = $order;
        $this->storeCommission = $storeCommission;
        $this->storeEarning    = $storeEarning;
    }

    /**
     * Handle the event.
     *
     * @param StoreEarningEvent $event
     * @return void
     */
    public function handle(StoreEarningEvent $event)
    {
        $order = $this->order->where('order_uid', $event->orderUid)->first();
        if (!$order) {
            return false;
        }
        $commissionPct = config('constants.DEFAULT_STORE_COMMISION');
        $storeComm     = $this->storeCommission->where('store_id', $order->store_id)->first();
        if ($storeComm) {
            $commissionPct = $storeComm->commison_percentage;
        }

        $commission_amount = round(($order->cart_subtotal * $commissionPct * 0.01), 2) -  ($order->cart_subtotal - $order->net_amount)  ;
        $this->storeEarning->Create([
            'order_id'        => $order->id,
            'order_uid'       => $order->order_uid,
            'store_id'        => $order->store_id,
            'actual_amount'   => $order->cart_subtotal,
            'amount_received' => $order->net_amount,
            'commission'      => $commission_amount,
            'payment_method'  => $order->payment_method,
        ]);
    }
}
