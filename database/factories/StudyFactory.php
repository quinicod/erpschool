<?php

use Faker\Generator as Faker;

$factory->define(App\study::class, function (Faker $faker) {
    return [
    'id_student' => \App\student::all()->random()->id,
    'id_grade' => \App\grade::all()->random()->id,
    ];
});
