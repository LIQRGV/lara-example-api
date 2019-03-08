<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PhoneNumber::class, function (Faker $faker) {
    return [
        'contact_owner_id' => App\Models\ContactOwner::inRandomOrder()->first()->id,
        'phone_number' => $faker->phoneNumber,
    ];
});
