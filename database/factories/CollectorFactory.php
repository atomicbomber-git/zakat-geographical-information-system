<?php

use Faker\Generator as Faker;

$factory->define(App\Collector::class, function (Faker $faker) {
    return [
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504,
        'name' => ucwords($faker->bs),
        'npwz' => $faker->unique->randomNumber(6),
        'address' => $faker->address
    ];
});
