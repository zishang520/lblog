<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('_SITECONFIG', Config::get('siteconfig'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
