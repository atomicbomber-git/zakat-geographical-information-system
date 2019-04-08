<?php

use Illuminate\Database\Seeder;
use App\Collector;
use App\Receivement;
use App\Mustahiq;

class ReceivementSeeder extends Seeder
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

            factory(Receivement::class, 60)
                ->make()
                ->each(function($receivement) use($collectors) {
                    $receivement->collector_id = $collectors->random()->id;
                    $receivement->save();
                });
        });
    }
}
