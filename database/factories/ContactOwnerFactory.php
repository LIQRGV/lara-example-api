<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ContactOwner::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomDigit(),
        'full_name' => $faker->name,
    ];
});
