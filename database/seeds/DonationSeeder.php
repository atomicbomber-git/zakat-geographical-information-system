<?php

use Illuminate\Database\Seeder;
use App\Collector;
use App\Donation;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collectors = Collector::select('id')->get();

        factory(Donation::class, 400)
            ->make()
            ->each(function($donation) use($collectors) {
                $donation->collector_id = $collectors->random()->id;
                $donation->save();
            });
    }
}
