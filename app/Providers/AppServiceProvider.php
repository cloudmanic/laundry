<?php

/**
 * File: AppServiceProvider.php
 * Description: Application service provider
 * Copyright: 2025 Cloudmanic Labs, LLC
 * Date: 2025-12-18
 */

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * Shares the active city configuration with all views.
     */
    public function boot(): void
    {
        $activeCity = config('city.active');
        $city = config("city.cities.{$activeCity}");

        View::share('city', $city);
    }
}
