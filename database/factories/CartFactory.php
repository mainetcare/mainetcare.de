<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cart;
use Faker\Generator as Faker;

$factory->define(Cart::class, function (Faker $faker) {
    return [
        'checkin' => $faker->dateTimeThisMonth,
        'checkout' => $faker->dateTimeThisMonth,
        'gaeste' => $faker->numberBetween(1,10),
        'teilnehmer' => $faker->numberBetween(0,9)
    ];
});
