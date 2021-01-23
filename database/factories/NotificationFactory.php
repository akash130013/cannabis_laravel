<?php

use Faker\Generator as Faker;
use App\Models\StoreNotifications;

$factory->define(StoreNotifications::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'store_id' => 15,
        'description' => $faker->text(100),
        'type' => 'order',
        'payload' => $faker->text(100)
    ];
});
