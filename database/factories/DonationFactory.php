<?php

use Faker\Generator as Faker;

$factory->define(App\Donation::class, function (Faker $faker) {
    return [
        'transaction_date' =>  now()->subYear(rand(1, 3)),
        "name" => $faker->name,
        "nik" => $faker->unique->randomNumber(6),
        "address" => $faker->streetAddress,
        "kecamatan" => $faker->randomElement(['A', 'B', 'C', 'D', 'E']),
        "kelurahan" => $faker->randomElement(['F', 'G', 'H', 'I', 'J']),
        "phone" => $faker->phoneNumber,
        "gender" => $faker->randomElement(['l', 'p']),
        "occupation" => $faker->randomElement(['Buruh', 'Kuli', 'Pedagang', 'Rumah Tangga']),
        "ansaf" => $faker->randomElement(['X', 'Y']),
        "help_program" => $faker->randomElement(['U', 'V']),
        "amount" => rand(10, 20) * 10000,
        'latitude' => rand(-50, 50) / 1000 + -0.026330,
        'longitude' => rand(-50, 50) / 1000 + 109.342504
    ];
});
