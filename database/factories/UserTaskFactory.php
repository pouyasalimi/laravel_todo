<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Psli\Todo\Models\UserTask;

$factory->define(UserTask::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->sentence(10),
        'status' => UserTask::STATUS[1],
        'user_id' => 1,
    ];
});
