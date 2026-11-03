<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

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
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Pengaturan HTTPS untuk ngrok
        |--------------------------------------------------------------------------
        */

        if (
            config('app.env') !== 'local' ||
            request()->header('X-Forwarded-Proto') === 'https'
        ) {
            URL::forceScheme('https');
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination menggunakan Bootstrap 5
        |--------------------------------------------------------------------------
        */

        Paginator::useBootstrapFive();
    }
}
