<?php

use Illuminate\Database\Seeder;
use App\Muzakki;
use App\Collector;

class MuzakkiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {

            $collectors = Collector::select("id")->get();

            factory(Muzakki::class, 300)
                ->make()
                ->each(function ($muzakki) use($collectors) {
                    $muzakki->collector_id = $collectors->random()->id;
                    $muzakki->save();
                });
        });
    }
}
