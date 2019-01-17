<?php

use Faker\Generator as Faker;

$factory->define(App\student::class, function (Faker $faker) {
    return [
    'name' => $faker->name,
    'lastname' => $faker->name,
    'age' => $faker->randomNumber(1)
    ];
});
