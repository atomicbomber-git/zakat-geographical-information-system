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
            "description" => "Sistem Informasi Geografis Zakat ini merupakan sebuah website yang menyajikan informasi tentang lokasi unit pengumpul zakat dan mustahiq. Website ini bertujuan untuk memberikan kemudahan kepada muzakki untuk memberi zakat kepada UPZ ataupun langsung kepada Mustahiq.",
        ]);
    }
}
