<?php

use Faker\Generator as Faker;

$factory->define(App\Donation::class, function (Faker $faker) {
    return [
        'transaction_date' =>  now()->subYear(rand(0, 3)),
        "amount" => rand(10, 20) * 10000000 * 3,
    ];
});
