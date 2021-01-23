<?php

namespace App\Listeners;

use App\Events\LPDebitEvent;
use App\Models\LoyaltyPointTransaction;
use App\Models\Order;
use App\Models\SiteConfig;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LPDebitListener
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
     * @param  LPDebitEvent  $event
     * @return void
     */
    public function handle(LPDebitEvent $event)
    {
        $lastAmount      = 0;

        $order = Order::where('order_uid', $event->orderUid)->first();
        if (!$order) {
            return false;
        }
        if (is_null($order->loyalty_point_used)){
            return false;
        }
        $loyaltyPoint =  LoyaltyPointTransaction::where('user_id', $event->userId)->latest()->first();
        if ($loyaltyPoint)
            $lastAmount = $loyaltyPoint->net_amount;

        LoyaltyPointTransaction::create([
            'user_id'         => $event->userId,
            'last_amount'     => $lastAmount,
            'operation'       => 'debit',
            'operated_amount' => $order->loyalty_point_used,
            'net_amount'      => $lastAmount - $order->loyalty_point_used,
            'reason'          => $event->reason,
            'remark'          => $event->remark,
        ]);


    }
}
