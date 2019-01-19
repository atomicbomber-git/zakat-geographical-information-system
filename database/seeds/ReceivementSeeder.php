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
        $collectors = Collector::select('id')->get();

        factory(Receivement::class, 200)
            ->make()
            ->each(function($receivement) use($collectors) {
                $receivement->collector_id = $collectors->random()->id;
                $receivement->save();
            });
    }
}
