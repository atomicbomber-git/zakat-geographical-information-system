<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(CollectorSeeder::class);
        $this->call(ReportSeeder::class);
        $this->call(MuzakkiSeeder::class);
        $this->call(ReceivementSeeder::class);
        $this->call(MustahiqSeeder::class);
        $this->call(DonationSeeder::class);
        $this->call(InformationSeeder::class);
    }
}
