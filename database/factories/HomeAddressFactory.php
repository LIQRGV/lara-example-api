<?php

use Faker\Generator as Faker;

$factory->define(App\Models\HomeAddress::class, function (Faker $faker) {
    return [
        'contact_owner_id' => App\Models\ContactOwner::inRandomOrder()->first()->id,
        'home_address' => $faker->address,
    ];
});
