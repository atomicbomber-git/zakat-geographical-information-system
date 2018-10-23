<?php

use Illuminate\Database\Seeder;
use App\Collector;
use App\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collector_ids = Collector::select('id')->pluck('id');

        foreach ($collector_ids as $collector_id) {
            factory(Report::class)->create([
                'collector_id' => $collector_id,
            ]);
        }
    }
}
