<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Rating::class, function (Faker $faker) {
    $order = \App\Models\Order::where('order_status', '!=', 'init')->get()->random(1)->first();
//    print_r($order);
    $user = \App\User::all()->random(1)->first();
    return [
        'rated_id'   => 1,
        'rate'       => rand(1, 5),
        'review'     => $faker->text(100),
        'order_id'   => $order->id,
        'order_uid'  => $order->order_uid,
        'store_id'   => $order->store_id,
        'created_by' => $user->id,
    ];
});
