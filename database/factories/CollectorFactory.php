<?php

use Faker\Generator as Faker;

$factory->define(App\Collector::class, function (Faker $faker) {
    return [
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504,
        'name' => $faker->bs,
        'address' => $faker->address
    ];
});
