<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
        'App\Events\LPCreditEvent'           => [
            'App\Listeners\LPCreditListener'
        ],
        'App\Events\LPDebitEvent'            => [
            'App\Listeners\LPDebitListener'
        ],
        'App\Events\PostPlaceOrderEvent'     => [
            'App\Listeners\CleanCartListener',
                'App\Listeners\UpdateUserPromoListener',
        ],
        'App\Events\DistributorOrderPaymentReceivedEvent' => [
            'App\Listeners\AdminEarningListener',
        ],
        'App\Events\NotifyStoreEvent' => [
          'App\Listeners\NotifyStoreListener',
        ],
        'App\Events\DriverOrderStatusEvent' => [
            'App\Listeners\DriverOrderStatusListener'
        ],
        'App\Events\StoreEarningEvent' => [
            'App\Listeners\StoreEarningListener'
        ],
        'App\Events\UserOrderEvent' => [
            'App\Listeners\UserOrderListener'
        ],


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
