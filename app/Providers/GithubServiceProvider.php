<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Http::macro('github', function () {
            return \Illuminate\Support\Facades\Http::withHeaders([
                'accept' => 'application/json',
//            'Authorization' => 'Bearer ' . config('github.token')
            ])
                ->baseUrl('https://api.github.com')
                ->withOptions(['verify' => false]);
        });
    }
}
