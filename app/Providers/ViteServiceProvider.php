<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViteServiceProvider extends ServiceProvider
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
        Vite::macro('image', fn(string $asset) => $this->asset("resources/images/{$asset}"));
        Vite::macro('font', fn(string $asset) => $this->asset("resources/fonts/{$asset}"));
    }
}
