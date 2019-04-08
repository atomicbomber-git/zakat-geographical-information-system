<?php

use Illuminate\Database\Seeder;
use App\Collector;

class MustahiqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {

            $collectors = Collector::select('id')->get();

            factory(App\Mustahiq::class, 300)
                ->make()
                ->each(function ($mustahiq) use($collectors) {
                    $mustahiq->collector_id = $collectors->random()->id;
                    $mustahiq->save();
                });
        });
    }
}
