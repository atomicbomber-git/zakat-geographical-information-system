<?php

use Illuminate\Database\Seeder;
use App\Collector;
use App\Receivement;

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
            $collectors = Collector::select('id')
                ->with("muzakkis:id,collector_id")
                ->get();

            factory(Receivement::class, 2000)
                ->make()
                ->each(function($receivement) use($collectors) {
                    $collector = $collectors->random();
                    $receivement->collector_id = $collector->id;
                    $receivement->muzakki_id = $collector->muzakkis->random()->id;
                    $receivement->save();
                });
        });
    }
}
