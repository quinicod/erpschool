<?php

use Faker\Generator as Faker;

$factory->define(App\petition::class, function (Faker $faker) {
    return [
    'id_company' => \App\company::all()->random()->id,
    'id_grade' => \App\grade::all()->random()->id,
    'type' => 'contrato',
    'n_students' => $faker->numberBetween($min=1,$max=3)
    ];
});
