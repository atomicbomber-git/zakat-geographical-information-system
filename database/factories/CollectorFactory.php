<?php

use Faker\Generator as Faker;

$factory->define(App\Collector::class, function (Faker $faker) {
    return [
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504,
        "kecamatan" => $faker->randomElement(['A', 'B', 'C', 'D', 'E']),
        "kelurahan" => $faker->randomElement(['F', 'G', 'H', 'I', 'J']),
        'name' => ucwords($faker->company),
        'npwz' => $faker->unique->randomNumber(6),
        'address' => $faker->streetAddress
    ];
});
