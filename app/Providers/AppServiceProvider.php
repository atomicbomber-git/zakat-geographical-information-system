<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Information;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('informations', $this->getInformations());

        Route::bind('any_collector', function($id) {
            return \App\Collector::withoutGlobalScopes()->findOrFail($id);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    private function getInformations()
    {
        try {
            $infomation = Information::query()
                ->select("id", "name")
                ->orderBy("name")
                ->get();

            return $infomation;
        }
        catch (\Exception $exception) {
            return null;
        }
    }
}
