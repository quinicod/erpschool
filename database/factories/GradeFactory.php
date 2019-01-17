<?php

use Faker\Generator as Faker;

$factory->define(App\grade::class, function (Faker $faker) {
    return [
    'name' => $faker->name,
    'level' => $faker->randomNumber(1)
    ];
});
