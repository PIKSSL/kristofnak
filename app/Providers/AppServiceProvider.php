<?php

namespace App\Providers;

use App\Models\Lending;
use App\Observers\LendingObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Lending::observe(LendingObserver::class);
    }
}
