<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Report;
use App\Collector;

$factory->define(Report::class, function (Faker $faker) {
    $collectors = Collector::select("id")->get();

    return [
        'collector_id' => $collectors->random()->id,
        'transaction_date' => Carbon::now()->subYear(rand(0, 5))->subMonth(rand(0, 5))->subDays(rand(0, 30)),
        'zakat' => rand(10, 20) * 10000000,
        'fitrah' => rand(10, 20) * 10000000,
        'fitrah_beras' => rand(10, 20) * 10000000,
        'infak' => rand(10, 20) * 10000000,
        'sedekah' => rand(10, 20) * 10000000,
    ];
});
