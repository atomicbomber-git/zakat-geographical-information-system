<?php

use Illuminate\Database\Seeder;
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
        DB::transaction(function () {
            factory(Report::class, 300)->create();
        });
    }
}
