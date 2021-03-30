<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cart;
use App\Models\CartItem;
use Faker\Generator as Faker;

$factory->define( CartItem::class, function ( Faker $faker ) {
    return [
        'cat'     => $faker->word,
        'title'   => $faker->word,
        'amount'  => $faker->numberBetween( 1, 10 ),
        'unit'    => $faker->word,
        'content' => $faker->text,
        'total'   => $faker->numberBetween( 1, 100 )
    ];
} );
