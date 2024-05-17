<?php

Route::get('/job', function () {
   \App\Jobs\TestJob::dispatch(10);

   // analogo a...
//   dispatch(new \App\Jobs\TestJob(10));

    return 'job creato';
});


Route::get('/job-unique', function () {
    \App\Jobs\UniqueJob::class::dispatch();


    return 'job creato';
});


Route::get('/job-sensible', function () {
    \App\Jobs\SensibleJob::dispatch([
        'pathologies' => ['tumor', 'allergy'],
        'user' => \App\Models\User::with('posts', 'posts.category', 'posts.likes', 'photos')->first(),
    ]);


    return 'job creato';
});


Route::get('/limited-job', function () {
    \App\Jobs\LimitedJob::dispatch(\App\Models\User::first()); // accoda il job
//    \App\Jobs\LimitedJob::dispatchIf($condition); // accoda il job se la condizione è vera
//    \App\Jobs\LimitedJob::dispatchUnless($condition); // accoda il job se la condizione è falsa

    \App\Jobs\LimitedJob::dispatch(\App\Models\User::first())->delay(now()->addSeconds(30)); // accoda il job


    return 'job creato';
});


Route::get('/long-job', function () {
    // il job viene eleaborato in modalità sincrona e la risposta viene inviata dopo che finisce l'elaborazione
//    \App\Jobs\LongJob::dispatch()->onConnection('sync');

    \App\Jobs\LongJob::dispatchAfterResponse();

    return 'job creato';
});


Route::get('/job-chain', function() {
    \Illuminate\Support\Facades\Bus::chain([
        new \App\Jobs\WithdrawFundsFromBankAccount(),
        new \App\Jobs\ChargeCredit(),
    ])->catch(function(Throwable $throwable) {
        dd($throwable);
    })->dispatch();

    return 'catena di job creata';

});


Route::get('/queues', function() {
    \App\Jobs\HighJob::dispatch()->onQueue('high');
    \App\Jobs\LowJob::dispatch()->onQueue('low');
});
