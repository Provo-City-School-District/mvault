<?php

namespace App\Providers;


use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\FooterComposer;

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
        Facades\View::composer('footer', FooterComposer::class);

        // Force HTTPS in non-local environments
        if (config('app.env') !== 'local') {
            Facades\URL::forceScheme('https');
        }
    }
}
