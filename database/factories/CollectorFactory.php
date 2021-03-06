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
        "name" => ucwords($faker->company),
        "reg_number" => $faker->unique->randomNumber(6),
        "address" => $faker->streetAddress,
        "phone" => $faker->phoneNumber,
        "is_verified" => 1,
    ];
});

$factory->afterCreating(App\Collector::class, function (App\Collector $collector) {
    $collector->members()
        ->saveMany(
            collect(["penasehat","ketua","sekretaris","bendahara","anggota_1","anggota_2",])
                ->map(function ($position) {
                    return factory(App\CollectorMember::class)
                        ->make(["position" => $position]);
                })
        );
});
