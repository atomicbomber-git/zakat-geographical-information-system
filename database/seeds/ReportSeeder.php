<?php

use Illuminate\Database\Seeder;
use App\Collector;
use App\Report;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $years_ago = 5;
        $collector_ids = Collector::select('id')->pluck('id');

        foreach ($collector_ids as $collector_id) {
            for ($year = 1; $year <= 5; ++$year) {
                factory(Report::class)->create([
                    'collector_id' => $collector_id,
                    'transaction_date' => Carbon::now()->subYear($year)
                ]);
            }
        }
    }
}
