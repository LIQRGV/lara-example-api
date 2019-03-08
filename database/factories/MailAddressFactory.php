<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MailAddress::class, function (Faker $faker) {
    return [
        'contact_owner_id' => App\Models\ContactOwner::inRandomOrder()->first()->id,
        'email' => $faker->email,
    ];
});
