<?php

use Faker\Generator as Faker;

$factory->define(App\Receiver::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "nik" => $faker->unique->randomNumber(6),
        "address" => $faker->streetAddress,
        "kecamatan" => $faker->randomElement(['A', 'B', 'C', 'D', 'E']),
        "kelurahan" => $faker->randomElement(['F', 'G', 'H', 'I', 'J']),
        "phone" => $faker->phoneNumber,
        "sex" => $faker->randomElement(['L', 'P']),
        "occupation" => $faker->randomElement(['Buruh', 'Kuli', 'Pedagang']),
        "ansaf" => $faker->randomElement(['X', 'Y']),
        "help_program" => $faker->randomElement(['U', 'V']),
        "amount" => rand(10, 20) * 10000000,
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504
    ];
});
