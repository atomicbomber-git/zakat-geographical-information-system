<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Collector;
use Illuminate\Support\Facades\Hash;

class CollectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {
            $users = factory(User::class, 20)
                ->make()
                ->each(function ($user, $index) {
                    $username = "collector_" . ($index + 1);
                    $user->type = 'COLLECTOR';
                    $user->username = $username;
                    $user->password = Hash::make($username);
                    $user->save();
                });

            foreach ($users as $user) {
                $collector = factory(Collector::class)->create([
                    'user_id' => $user->id
                ]);

                $collector->addMedia(__DIR__ . '/random.jpeg')
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        });
    }
}
