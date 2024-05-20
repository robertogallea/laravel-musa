<?php

use App\Models\Post;

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


Route::get('/job-chain', function () {
    \Illuminate\Support\Facades\Bus::chain([
        new \App\Jobs\WithdrawFundsFromBankAccount(),
        new \App\Jobs\ChargeCredit(),
    ])->catch(function (Throwable $throwable) {
        dd($throwable);
    })->dispatch();

    return 'catena di job creata';

});


Route::get('/queues', function () {
    \App\Jobs\HighJob::dispatch()->onQueue('high');
    \App\Jobs\LowJob::dispatch()->onQueue('low');
});


Route::get('/backoff', function () {
    \App\Jobs\HighJob::dispatch();

    return 'job creato';
});


Route::get('/release', function () {
    \App\Jobs\ReleasedJob::dispatch();

    return 'job creato';
});

Route::get('/fail', function () {
    \App\Jobs\FailingJob::dispatch();

    return 'job creato';
});


Route::get('/batch', function () {
    $batch = \Illuminate\Support\Facades\Bus::batch([
        new \App\Jobs\LowJob(),
        new \App\Jobs\FailingJob(),
    ])
        ->before(function (\Illuminate\Bus\Batch $batch) {
            \Illuminate\Support\Facades\Log::info('Prima del batch');
        })
        ->progress(function (\Illuminate\Bus\Batch $batch) {
            \Illuminate\Support\Facades\Log::info('Un job del batch è stato completato');
        })
        ->then(function (\Illuminate\Bus\Batch $batch) {
            \Illuminate\Support\Facades\Log::info('Tutti i job del batch completati');
        })
        ->catch(function (\Illuminate\Bus\Batch $batch) {
            \Illuminate\Support\Facades\Log::info('Uno dei job del batch è fallito');
        })
        ->finally(function (\Illuminate\Bus\Batch $batch) {
            \Illuminate\Support\Facades\Log::info('Batch terminato');
        })
        // con questa opzione il fallimento di un singolo job non comporta il fallimento dell'intero batch
        ->dispatch();

    dd($batch);
});

Route::get('/batch/{id}', function ($id) {
    dd(\Illuminate\Support\Facades\Bus::findBatch($id));
});

Route::get('/chain-of-batch', function () {

    Bus::chain([
        new \App\Jobs\HighJob(),
        Bus::batch([
            new \App\Jobs\LowJob(),
            new \App\Jobs\LowJob(),
        ]),
    ]);
});


Route::get('/batch-of-chain', function () {
    Bus::batch([
        new \App\Jobs\HighJob(),
        [
            new \App\Jobs\WithdrawFundsFromBankAccount(),
            new \App\Jobs\ChargeCredit(),
            new \App\Jobs\WithdrawFundsFromBankAccount(),
            new \App\Jobs\ChargeCredit(),
        ]
    ]);
});


Route::get('/http', function () {

    $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
        ->get('https://api.github.com/search/repositories?q=laravel&order=desc&per_page=30');

    $data = $response->json();


    return view('repositories.index', compact('data'));
});

Route::get('http-macro', function () {
    $response = \Illuminate\Support\Facades\Http::github()
        ->get('/search/repositories?q=laravel&order=desc&per_page=30');

    $data = $response->json();
    return view('repositories.index', compact('data'));
});

Route::get('http-timeout', function () {
    // timeout di default pari a 30 secondi
    $response = \Illuminate\Support\Facades\Http::github()
//        ->timeout(10) // timeout entro cui ricevere una risposta
        ->connectTimeout(1) // timeout entro cui stabilire la connessione con il server
        ->get('/search/repositories?q=laravel&order=desc&per_page=30');
    dd($response->body());
});

Route::get('http-retry', function () {
    $response = \Illuminate\Support\Facades\Http::
    retry(10, 1000)
        ->get('blabla.bla');

    $response = \Illuminate\Support\Facades\Http::
    retry(10, function (int $attempt, $exception) {
        return 100 * $attempt;
    })
        ->get('blabla.bla');

    dd($response->body());
});


Route::get('http-pool', function () {
//    $response1 = \Illuminate\Support\Facades\Http::github()
//        ->get('/search/repositories?q=laravel&order=desc&per_page=30');
//
//    $response2 = \Illuminate\Support\Facades\Http::github()
//        ->get('/search/repositories?q=php&order=desc&per_page=30');
//
//    $response3 = \Illuminate\Support\Facades\Http::github()
//        ->get('/search/repositories?q=mysql&order=desc&per_page=30');
//
//    dump($response1->json());
//    dump($response2->json());
//    dump($response3->json());
//
    $response = \Illuminate\Support\Facades\Http::pool(fn(Illuminate\Http\Client\Pool $pool) => [
        $pool->as('laravel')->withOptions(['verify' => false])->get('https://api.github.com/search/repositories?q=laravel&order=desc&per_page=30'),
        $pool->as('php')->withOptions(['verify' => false])->get('https://api.github.com/search/repositories?q=php&order=desc&per_page=30'),
        $pool->as('mysql')->withOptions(['verify' => false])->get('https://api.github.com/search/repositories?q=mysql&order=desc&per_page=30'),
    ]);

    dump($response['laravel']->json());
    dump($response['php']->json());
    dump($response['mysql']->json());


});


Route::get('/mail', function () {
    \Illuminate\Support\Facades\Mail::to(\App\Models\User::find(1)) // invio ad un utente specifico
        ->send(new \App\Mail\TestMail());
});

Route::get('/mail-without-user', function () {
    \Illuminate\Support\Facades\Mail::to([ // invio ad un array di destinatari identificati da campo name e email
        [
            'name' => 'Destinatario 1',
            'email' => 'email@email.it',
        ],
        [
            'name' => 'Destinatario 2',
            'email' => 'email2@email.it',
        ]
    ])
        ->cc(\App\Models\User::find(2)) // copia carbone
        ->bcc(\App\Models\User::find(3)) // copia carbone nascosta
        ->send(new \App\Mail\TestMail());
});

Route::get('mail-job', function () {
    $mail = new \App\Mail\TestMail();

    \Illuminate\Support\Facades\Mail::to(\App\Models\User::first())
        ->queue(
            $mail
//                ->onQueue('mail') // per impostare una coda specifica
//                ->onConnection('redis') // per impostare una connessione specifica
        );
//    ->later(now()->addHours(5), new \App\Mail\TestMail()); // per effettuare un invio differito
});


Route::get('/mail-with-data', function () {
    $post = Post::orderBy('id', 'desc')->first();

    \Illuminate\Support\Facades\Mail::to(\App\Models\User::find(1)) // invio ad un utente specifico
    ->send(new \App\Mail\TestMailWithData([
        'a' => 1,
        'b' => 2,
    ], $post));
});


Route::get('/mail-preview', function() {
    $post = Post::orderBy('id', 'desc')->first();

    return new \App\Mail\TestMailWithData([], $post);
});

Route::get('/mail-with-attachment', function () {
   \Illuminate\Support\Facades\Mail::to(\App\Models\User::find(1))
        ->send(new \App\Mail\TestMailWithAttachment());
});

Route::get('/mail-markdown', function () {
    $post = Post::latest('id')->first();

    \Illuminate\Support\Facades\Mail::to(\App\Models\User::find(1))
//        ->locale('es') // oppure possiamo implementare l'interfaccia HasLocalePreference nel modello user, scrivendo il metodo preferredLocale()
        ->send(new \App\Mail\TestMailMarkdown($post));
});

Route::get('/error', function() {
   1/0;
});
