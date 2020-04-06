<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'=> $faker->lastName,
        'user_id' => factory('App\User')->create()->id,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
