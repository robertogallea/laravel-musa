<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function() {
            Route::prefix('/admin')
                ->name('admin.')
                ->middleware(['throttle:admin', 'auth', 'web'])
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

            // middleware di sanctum
            'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (DivisionByZeroError $exception) {
            \App\Jobs\HandleDivisionByZero::dispatch();

//            return false; // per disabilitare la riga di log di default
        }); // per disabilitare la riga di log di default (alternativa)

        // Per definire un livello di severità specifico per una tipologia di eccezione
        $exceptions->level(DivisionByZeroError::class, \Psr\Log\LogLevel::CRITICAL);

        // Per ignorare il reporting di una tipologia di eccezione
//        $exceptions->dontReport([
//            DivisionByZeroError::class
//        ]);

        /*
         * Alcune eccezioni vengono ignorate di default.
         * Per smettere di ignorarle e tracciarle, posso utilizzare stopIgnoring()
         */
        $exceptions->stopIgnoring(
            Symfony\Component\HttpKernel\Exception\HttpException::class
        );

        // cambia la modalità di risposta dell'applicazione al verificarsi di una eccezione
//        $exceptions->render(function (DivisionByZeroError $exception, Request $request) {
//            return response()->view('errors.division-by-zero', compact('exception', 'request'), 500);
//        });

        // cambia l'intera risposta HTTP dell'applicazione
//        $exceptions->respond(function (DivisionByZeroError $exception, Request $request) {
//            // ...
//        });

        $exceptions->throttle(function (Throwable $exception) {
            if ($exception instanceof DivisionByZeroError) {
                return \Illuminate\Support\Lottery::odds(1, 2);
            } else {
                return \Illuminate\Support\Lottery::odds(1, 100);
            }
        });

    })->create();
