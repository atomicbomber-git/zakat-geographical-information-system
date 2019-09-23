<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Collector;
use App\Enums\UserType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class CollectorSeeder extends Seeder
{
    const AMOUNT = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {

            Collection::times(self::AMOUNT, function ($number) {

                collect([TRUE, FALSE])
                    ->each(function ($is_verified) use($number) {
                        $username = $is_verified ? "collector_{$number}" :
                            "unverified_{$number}";

                        $user = factory(User::class)
                            ->create([
                                "type" => UserType::ADMINISTRATOR,
                                "username" => $username,
                                "password" => Hash::make($username),
                            ]);

                        $collector = factory(Collector::class)
                            ->create([
                                'user_id' => $user->id,
                                'is_verified' => $is_verified,
                            ]);

                        $collector->addMedia(__DIR__ . '/random.jpeg')
                            ->preservingOriginal()
                            ->toMediaCollection('images');

                        $collector->user()
                            ->associate($user)
                            ->save();
                    });
            });
        });
    }
}
