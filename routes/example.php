<?php

use App\Services\BookImporterService;
use App\Services\BookPublisher;
use App\Services\BookService;
use App\Services\DBExportService;
use App\Services\ExportingServiceInterface;
use App\Services\RandomService;

// zero configuration
Route::get('/container', function(BookService $service) {
    $service->load();
});

Route::get('/container-recursive', function(BookPublisher $service) {
    dd($service);
});

Route::get('/singleton', function() {
    $service = app()->get(RandomService::class);
    dump($service->get());
    $service2 = app()->get(RandomService::class);
    dump($service2->get());
});

Route::get('/dip', function(ExportingServiceInterface $service) {
    dd($service->export());
});

Route::get('/binding-primitives', function (BookImporterService $service) {
    dd($service);
});
