<?php

namespace App\Providers;

use App\Services\BookImporterService;
use App\Services\BookService;
use App\Services\DBExportService;
use App\Services\ExportingServiceInterface;
use App\Services\FileExportService;
use App\Services\RandomService;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // registro i servizi a disposizione dell'applicazione


        // crea il binding fra una classe ed il risultato di una funzione
        $this->app->bind(BookService::class, function($application) {
            return new BookService('some configuration');
        });

        // crea il binding fra una classe ed il risultato di una funzione solo se già
        // non esiste un binding precedente
        $this->app->bindIf(BookService::class, function($application) {
            return new BookService('some other configuration');
        });

        // crea il binding e riutilizza la stessa istanza per tutte le richieste fatte al container
        // (non crea ogni volta una nuova istanza)
        $this->app->singleton(RandomService::class, function($application) {
            return new RandomService();
        });

        // come per bindIf ma per i singleton
//        $this->app->singletonIf(...);

        // instance definisce il binding su una istanza specifica della classe
        $bookService = new BookService('custom configuration');
        $this->app->instance(BookService::class, $bookService);

        // crea il binding fra un'interfaccia ed una implementazione concreta
        $this->app->bind(
            ExportingServiceInterface::class,
            config('app.export-service'),
        );

        // risoluzione di dipendenze verso valori primitivi
        $this->app->when(BookImporterService::class)
            ->needs('$filename')
            ->give('c:/filename.txt');
        //->giveConfig('app.filename');

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // avvio i servizi dell'applicazione potendo avere la certezza che sono stati tutti caricati
        // (anche quelli di altri service provider)
    }
}
