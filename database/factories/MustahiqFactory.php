<?php

use Faker\Generator as Faker;
use App\Mustahiq;

$factory->define(App\Mustahiq::class, function (Faker $faker) {

    $kecamatan = $faker->randomElement(['A', 'B', 'C', 'D', 'E']);
    $kelurahan = $kecamatan . $faker->randomElement(['P', 'Q', 'R', 'T', 'U']);

    return [
        "name" => $faker->name,
        "nik" => $faker->unique->randomNumber(6),
        "address" => $faker->streetAddress,
        "kecamatan" => $kecamatan,
        "kelurahan" => $kelurahan,
        "phone" => $faker->phoneNumber,
        "gender" => $faker->randomElement(['l', 'p']),
        "occupation" => $faker->randomElement(['Buruh', 'Kuli', 'Pedagang', 'Rumah Tangga']),
        "asnaf" => $faker->randomElement(Mustahiq::ASNAFS),
        "help_program" => $faker->randomElement(['U', 'V']),
        "age" => rand(14, 80),
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504
    ];
});
