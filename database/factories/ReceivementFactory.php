<?php

use Faker\Generator as Faker;

$factory->define(App\Receivement::class, function (Faker $faker) {
    return [
        'transaction_date' =>  now()->subYear(rand(0, 3)),
        'zakat' => rand(10, 20) * 10000000,
        'fitrah' => rand(10, 20) * 10000000,
        'infak' => rand(10, 20) * 10000000
    ];
});
