<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use App\Mustahiq;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('act-as-administrator', function($user) {
            return $user->type == 'ADMINISTRATOR';
        });

        Gate::define('act-as-collector', function($user) {
            return $user->type == 'COLLECTOR';
        });

        Gate::define('update', function(User $user, Mustahiq $mustahiq) {
            return $user->collector->id === $mustahiq->collector_id;
        });

        Gate::define('delete', function(User $user, Mustahiq $mustahiq) {
            return ($mustahiq->donations_count ?? 1) === 0;
        });
    }
}
