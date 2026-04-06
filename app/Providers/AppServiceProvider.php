<?php

namespace App\Providers;

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
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || env('RAILWAY_ENVIRONMENT')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            
            // Force session cookie to be secure
            config(['session.secure' => true]);
        }
    }
}
