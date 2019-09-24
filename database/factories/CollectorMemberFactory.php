<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\CollectorMember;
use Faker\Generator as Faker;

$factory->define(CollectorMember::class, function (Faker $faker) {
    return [
        "name" => $faker->name(),
        "position" => $faker->word(),
    ];
});
