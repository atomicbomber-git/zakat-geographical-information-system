<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use App\Mustahiq;
use App\Muzakki;
use App\Policies\MustahiqPolicy;
use App\Policies\MuzakkiPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Mustahiq::class => MustahiqPolicy::class,
        Muzakki::class => MuzakkiPolicy::class,
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

        Gate::define('see-muzakkis-on-map', function (?User $user) {
            return $user !== null;
        });
    }
}
