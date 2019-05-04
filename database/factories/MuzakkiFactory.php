<?php

use Faker\Generator as Faker;

$factory->define(App\Muzakki::class, function (Faker $faker) {

    $kecamatan = $faker->randomElement(['A', 'B', 'C', 'D', 'E']);
    $kelurahan = $kecamatan . $faker->randomElement(['P', 'Q', 'R', 'T', 'U']);

    return [
        'name' => $faker->name,
        'NIK' => $faker->randomNumber(6),
        'address' => $faker->streetAddress,
        'kecamatan' => $kecamatan,
        'kelurahan' => $kelurahan,
        'phone' => $faker->phoneNumber,
        'gender' => $faker->randomElement(['l', 'p']),
        'npwz' => $faker->randomNumber(6),
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504
    ];
});
