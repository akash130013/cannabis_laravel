<?php

namespace App\Listeners;

use App\Events\LPCreditEvent;
use App\Models\LoyaltyPointTransaction;
use App\Models\Order;
use App\Models\SiteConfig;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LPCreditListener
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
     * @param LPCreditEvent $event
     * @return void
     */
    public function handle(LPCreditEvent $event)
    {
        $lastAmount = $operated_amount = 0;
        if ($event->reason == config('constants.LOYALTY_POINTS_REASONS.REFERRED')) {
            $operated_amount = $this->getConversionRate('REFERRAL_LOYALTY_CONVERSION_RATE');
        }
        if ($event->reason == config('constants.LOYALTY_POINTS_REASONS.PURCHASE')) {
            $operated_amount = $this->getConversionRate('PURCHASE_LOYALTY_CONVERSION_RATE');
        }
        if ($event->reason == config('constants.LOYALTY_POINTS_REASONS.REFUNDED') && isset($event->orderUid)){
            $order = Order::where('order_uid', $event->orderUid)->first();
            if (!$order)  return false;
            $operated_amount =  round($order->loyalty_point_used,2);
        }

        $loyaltyPoint = LoyaltyPointTransaction::where('user_id', $event->userId)->latest()->first();
        if ($loyaltyPoint) {
            $lastAmount = $loyaltyPoint->net_amount;
        }

        LoyaltyPointTransaction::create([
            'user_id'         => $event->userId,
            'last_amount'     => $lastAmount,
            'operation'       => 'credit',
            'operated_amount' => $operated_amount,
            'net_amount'      => $lastAmount + $operated_amount,
            'reason'          => $event->reason,
            'remark'          => $event->remark,
        ]);


    }

    protected function getConversionRate($key){
        $conversionValue = SiteConfig::where('key', $key)->first();
        if (!$conversionValue) return false;
        return $conversionValue->value;

    }
}
