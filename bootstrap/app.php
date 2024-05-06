<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function() {
            Route::prefix('/admin')
                ->name('admin.')
                ->middleware(['throttle:admin'])
                ->group(base_path('routes/admin.php'));

            Route::prefix('/example')
                ->name('example.')
                ->group(base_path('/routes/example.php'));

            // posso inserire quanti gruppi desidero
            /*
            Route::prefix('/testers')
                ->group(base_path('routes/testers.php'));
            */
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //$middleware->append(\App\Http\Middleware\TestMiddleware::class);
        $middleware->alias([
            'magic' => \App\Http\Middleware\TestMiddleware::class,
            'highlight' => \App\Http\Middleware\HighlightText::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
