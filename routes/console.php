<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



Artisan::command('other-test', function() {
   $this->info('Another test command');
})->purpose('Another example command');

// schedulo la scrittura di una funzione anonima ogni giorno a mezzanotte
\Illuminate\Support\Facades\Schedule::call(function () {
    \Illuminate\Support\Facades\Log::info('It\'s midnight!');
})->daily();

// schedulo il dispatch in coda di un job ogni 5 minuti
\Illuminate\Support\Facades\Schedule::job(new \App\Jobs\TestJob(rand(1,10)))->everyFiveMinutes();

\Illuminate\Support\Facades\Schedule::exec('composer update')->everyMinute();

// cosa succede se l'operazione richiesta da composer update impiega più di un minuto?
// Le due operazioni si sovrappongono

\Illuminate\Support\Facades\Schedule::exec('composer update')
    ->everyMinute()
    ->withoutOverlapping();


// cosa succede se lo scheduler manda in esecuzione contemporaneamente i due comandi seguenti?
//
//\Illuminate\Support\Facades\Schedule::exec(new \App\Console\Commands\ConvertPostsToPDF())->everyTwoHours()->runInBackground();
//// il processo in background viene eseguito su un sotto-processo
//// lasciando il processo principale libero di eseguire le altre operazioni
//
//\Illuminate\Support\Facades\Schedule::call(function() {
//    sleep(5);
//})->everyMinute();



// se voglio eseguire una operazione dopo il completamento di una operazione schedulata
\Illuminate\Support\Facades\Schedule::call(function () {
    // ...
})->onSuccess(function() {
    // fai qualcosa se l'operazione completa correttamente
})->onFailure(function() {
    // fai qualcosa se l'operazione fallisce
})->onOneServer();

\Illuminate\Support\Facades\Schedule::command('blog:categories')
    ->everyTenSeconds()
    ->appendOutputTo(storage_path('output.txt')) // aggiunge al contenuto esistente di un file
    ->sendOutputTo(storage_path('last_output.txt')) // sovrascrive il file
    ->emailOutputTo('test@test.it') // manda per email l'output del comando
    ->emailOutputOnFailure('test@test.it') // manda per email l'output del comando ma solo se fallisce
    ->onSuccessWithOutput(function ($output) {
        // possiamo utilizzare l'output in modo arbitrario
    });
;

