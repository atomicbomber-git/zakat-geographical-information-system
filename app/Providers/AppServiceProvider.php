<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Information;
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
