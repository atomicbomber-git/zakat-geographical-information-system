<?php

use Illuminate\Database\Seeder;

class ReceiverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {
            factory(App\Receiver::class, 200)->create();
        });
    }
}
