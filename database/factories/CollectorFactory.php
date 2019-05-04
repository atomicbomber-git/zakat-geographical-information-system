<?php

use Faker\Generator as Faker;

$factory->define(App\Collector::class, function (Faker $faker) {

    $kecamatan = $faker->randomElement(['A', 'B', 'C', 'D', 'E']);
    $kelurahan = $kecamatan . $faker->randomElement(['P', 'Q', 'R', 'T', 'U']);

    return [
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504,
        "kecamatan" => $kecamatan,
        "kelurahan" => $kelurahan,
        'name' => ucwords($faker->company),
        'npwz' => $faker->unique->randomNumber(6),
        'address' => $faker->streetAddress
    ];
});
