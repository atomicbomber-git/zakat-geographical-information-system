<?php

use Faker\Generator as Faker;

$factory->define(App\Muzakki::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'NIK' => $faker->randomNumber(6),
        'kecamatan' => $faker->randomElement(['A', 'B', 'C', 'D', 'E']),
        'kelurahan' => $faker->randomElement(['P', 'Q', 'R', 'T', 'U']),
        'phone' => $faker->phoneNumber,
        'gender' => $faker->randomElement(['l', 'p']),
        'npwz' => $faker->randomNumber(6),
        'zakat' => rand(10, 20) * 10000000,
        'fitrah' => rand(10, 20) * 10000000,
        'infak' => rand(10, 20) * 10000000
    ];
});