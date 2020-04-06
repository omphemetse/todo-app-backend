<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(8,true),
        'complete' => $faker->boolean,
        'user_id' => factory('App\User')->create()->id,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
