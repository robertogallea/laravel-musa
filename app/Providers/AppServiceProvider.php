<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        RateLimiter::for('admin', function(Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()?->id ?: $request->ip());
        });


        ViewFacade::share('now', now());
        // Tutte le viste avranno a disposizione una variabile $now contenente data/ora di sistema


        // View composers - eseguono una callback prima della generazione di una particolare vista
        /*
        ViewFacade::composer('welcome', function (View $view) {
            dump('composer eseguito');
        });

        // Anche su più viste
        ViewFacade::composer(['welcome', 'dashboard'], function (View $view) {
            dump('composer eseguito');
        });

        ViewFacade::composer('*', function (View $view) {
            dump('composer eseguito ' . $view->getName());
        });
        */
    }
}
