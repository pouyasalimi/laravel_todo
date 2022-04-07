<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Psli\Todo\Models\Label;

$factory->define(Label::class, function (Faker $faker) {
    return [
        'label' => $faker->unique()->colorName,
    ];
});
