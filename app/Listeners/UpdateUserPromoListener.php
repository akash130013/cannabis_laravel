<?php

namespace App\Listeners;

use App\Events\PostPlaceOrderEvent;
use App\Models\PromoCode;
use App\Models\UserPromoCode;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserPromoListener
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
     * @param PostPlaceOrderEvent $event
     * @return void
     */
    public function handle(PostPlaceOrderEvent $event)
    {
        $userPromoCode = UserPromoCode::where(['order_uid' => $event->orderUid, 'user_id' => $event->userId])->first();
        if ($userPromoCode) {
            $promoCode = PromoCode::where('coupon_code', $userPromoCode->promo_code)->decrement('coupon_remained');
            $userPromoCode->status = "redeemed";
            $userPromoCode->save();
        }
    }
}
