<?php

use Illuminate\Database\Seeder;
use App\Collector;
use App\Donation;
use Illuminate\Support\Facades\DB;

class DonationSeeder extends Seeder
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
                ->with("mustahiqs:id,collector_id")
                ->get();

            factory(Donation::class, 1600)
                ->make()
                ->each(function($donation) use($collectors) {
                    $collector = $collectors->random();
                    $donation->collector_id = $collector->id;
                    $donation->mustahiq_id = $collector->mustahiqs->random()->id;
                    $donation->save();
                });
        });
    }
}
