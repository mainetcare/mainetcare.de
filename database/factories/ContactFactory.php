<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define( Contact::class, function ( Faker $faker ) {
    return [
        'name'     => $faker->name,
        'vorname'  => $faker->firstName,
        'email'    => $faker->email,
        'telefon'  => $faker->phoneNumber,

        'strasse'  => $faker->streetAddress,
        'plz'      => $faker->postcode,
        'ort'      => $faker->city,

        'hinweise' => $faker->text

    ];
} );
