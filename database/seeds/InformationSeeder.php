<?php

use Illuminate\Database\Seeder;
use App\Information;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        Information::create([
            "name" => "Penjelasan Situs",
            "description" => $faker->realtext(5000),
        ]);
    }
}
