<?php

use Illuminate\Database\Seeder;
use App\Collector;
use App\Donation;
use App\Mustahiq;

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
            $collectors = Collector::select('id')->get();
            $mustahiqs = Mustahiq::select('id')->get();

            factory(Donation::class, 400)
                ->make()
                ->each(function($donation) use($collectors, $mustahiqs) {
                    $donation->collector_id = $collectors->random()->id;
                    $donation->mustahiq_id = $mustahiqs->random()->id;
                    $donation->save();
                });
        });
    }
}
