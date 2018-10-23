<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Report::class, function (Faker $faker) {
    return [
        'transaction_date' => Carbon::now()->subYear(rand(1, 3)),
        'zakat' => rand(10, 20) * 10000000,
        'fitrah' => rand(10, 20) * 10000000,
        'infak' => rand(10, 20) * 10000000,
        'note' => $faker->sentence(3)
    ];
});
