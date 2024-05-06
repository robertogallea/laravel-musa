<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::[verb](path, handler);

// verb
// - get        Visualizzare una risorsa
// - post       Salvare una nuova risorsa
// - put        Aggiornare una risorsa esistente - sempre idempotente
// - patch      Aggiornare una risorsa esistente - non necessariamente idempotente
// - delete     Eliminare una risorsa

// Rotta per un verbo specifico
Route::get('/tests', function () {
    return 'Ciao';
});

// Rotta per verbi multipli
Route::match(['get', 'delete'], '/multi', fn() => 'verbo multiplo');

// Rotta per qualsiasi verbo
Route::any('/any', fn() => 'qualsiasi verbo');

// Injection dell'oggetto Request
Route::get('/request_injection', function (Request $request) {
    return $request->all();
});

// Redirect routes
Route::redirect('/redirect', '/tests');

// View routes
Route::view('/view', 'welcome');
// equivalente a
/*
Route::get('/view', function() {
    return view('welcome');
});
*/

// View routes with parameters
Route::view('/viewdata', 'example', ['title' => 'Titolo della pagina']);
// equivalente a
/*
Route::get('/viewdata', function() {
    return view('example', ['title' => 'Titolo della pagina']);
});
*/


// Rotta parametrica
Route::get('/show/{id}', function ($id) {
    return 'Il parametro è ' . $id;
})->name('show');

// Rotta parametrica con parametri multipli
Route::get('/show2/{id}/{value}', function ($id, $value) {
    return 'Il parametro è ' . $id . ' con valore ' . $value;
});

// Rotta parametrica con parametri non obbligatori
Route::get('/show3/{id}/{value?}', function ($id, ?string $value = null) {
    return 'Il parametro è ' . $id . ' con valore ' . ($value ?? 'non specificato');
});

Route::get('/show4/{id?}/{value?}', function (?string $id = null, ?string $value = null) {
    return 'Il parametro è ' . ($id ?? 'non specificato') . ' con valore ' . ($value ?? 'non specificato');
});

// Parametri vincolati


// espressioni regolari - solo numeri positivi
Route::get('/regex1/{id}', function ($id) {
    return $id;
})->where('id', '[0-9]+');

// espressioni regolari - solo stringhe alfabetiche
Route::get('/regex2/{id}', function ($id) {
    return $id;
})->where('id', '[A-Za-z]+');

// espressioni regolari - parametri multipli
Route::get('/regex3/{id}/{name}', function ($id, $name) {
    return $id . ' ' . $name;
})->where([
    'id' => '[0-9]+',
    'name' => '[A-Za-z]+'
]);
// array associativo a cui per ogni chiave (parmetro) assegno un valore (espressione regolare da utilizzare)


// espressioni regolari semplici
Route::get('/regex4/{id}/{name}', function ($id, $name) {
    return $id . ' ' . $name;
})
    ->whereNumber('id')
    ->whereAlphaNumeric('name');

Route::get('/wherein/{param}', function ($param) {
    return $param;
})->whereIn('param', ['mela', 'pera', 'banana']);

Route::get('/uuid/{uuid}', function ($uuid) {
    return $uuid; // universal unique identifier
})->whereUuid('uuid');


// Named routes
// Supponiamo di avere la seguente rotta
// Route::get('/route1', fn() => 'ok');

/*
<a href="/route1">LINK</a>
*/

// Se in un secondo momento decido di rinominare la rotta e la chiamo...
// Route::get('/route2', fn() => 'ok');

// Per evitare di modificare il link in tutta la codebase
// assegno un nome alla rotta
Route::get('/route1', fn() => 'ok')->name('my-route');

// Quando creo il link lo creerò così:
/*
<a href="{{ route('my-route') }}">LINK</a>
*/
// Viene trasformato in
// <a href="/route1">LINK</a>

// Se però adesso cambio il percorso della rotta in
// Route::get('/route2', fn() => 'ok')->name('my-route');

// Non ho necessità di modificare nulla nella vista perchè
/*
<a href="{{ route('my-route') }}">LINK</a>
*/
// Viene trasformato in
// <a href="/route2">LINK</a>


// Named routes with parameters
Route::get('/named/{parameter}', fn($parameter) => $parameter)
    ->name('named');

// Se il parametro è obbligatorio bisogna fornirne il valore
// quando si genera l'url usando la funzione route()
// route('named', ['parameter' => 'my-value']);

// Se uno o più parametri non fanno parte della definizione della rotta
// Essi vengono accodati come parametri GET dell'URL

/*
route('named', ['parameter' => 'my-value', 'var' => 10, 'var2' => 12])
da come risultato
"http://localhost/named/my-value?var=10&var2=12"
*/


// MODEL BINDING
// Se passo un parametro e fornisco un type hint per il parametro
// Se il tipo richieste è un modello, viene letta la riga del db
// che ha per chiave primaria il valore del parametro
// e se esiste viene passata l'istanza del modello corrispondente.
Route::get('/users/{user}', function (User $user) {
    dd($user);
});

// SELECT * FROM users WHERE id = 1;

// MODEL BINDING WITH CUSTOM KEY
Route::get('/users2/{user:email}', function (User $user) {
    dd($user);
});

// SELECT * FROM users WHERE email = 'tests@tests.it';

// MISSING BINDING
Route::get('/users3/{user}', function (User $user) {
    dd($user);
})->missing(function () {
    return redirect('/');
    // Nel caso in cui non sia possibile effettuare il binding
    // è possibile fare un redirect invece di fornire errore 404
});


Route::get('/request', function (Request $request) {
    // Percorso relativo
    dump('Percorso relativo: ' . $request->path());

    // Test sul percorso
    dump($request->is('example/request')); // true
    dump($request->is('example/*'));  // true
    dump($request->is('tests/request')); // false
    dump($request->is('example/*/tests')); // false

    // Test sul nome della roota
    dump($request->routeIs('example.tests')); // true
    dump($request->routeIs('example.*')); // true

    // Informazioni sul percorso assoluto
    dump('URL della richiesta: ' . $request->url());
    dump('URL della richiesta: ' . $request->fullUrl());

    // Aggiunta o esclusione parametri get dall'URL
    dump('URL della richiesta con parametri: ' . $request->fullUrlWithQuery([
            'par1' => 'abc',
            'par2' => 123,
        ])
    );

    dump('URL della richiesta senza un parametro' . $request->fullUrlWithoutQuery(['type']));


    // Estrazione dell'host dalla request
    dump('Host: ' . $request->host()); // Host: 127.0.0.1
    dump('HTTP Host: ' . $request->httpHost()); // Host: 127.0.0.1:8000
    dump('Scheme and HTTP Host: ' . $request->schemeAndHttpHost()); // Host: http://127.0.0.1:8000


    // Test sul verbo HTTP della richiesta
    dump($request->isMethod('post')); // false
    dump($request->isMethod('get')); // true

    dump('Header User-Agent:' . $request->header('User-Agent'));
    dump('Header X-Header:' . $request->header('X-Header')); // null se non esiste
    dump('Header X-Header:' . $request->header('X-Header', 'Default value')); // o fornisco valore default


    // IP del client
    dump('IP del client: ' . $request->ip());


    // Content negotiation
    dump($request->getAcceptableContentTypes());

    // Test del tipo MIME
    dump($request->accepts('text/html')); // true
    dump($request->accepts(['text/html', 'application/json'])); // true
    dump($request->accepts('xxx/not-existing')); // true, solo se esiste * o */* nei tipi accettati

    dump($request->prefers(['application/xml', 'text/html'])); // dato un set di tipi fornisce il preferito
    // quelle presente per primo nella lista degli tipi accettati


})->name('tests');


Route::get('/input', function (Request $request) {

    // esempi sull'url http://127.0.0.1:8000/example/input?a=2&b=ciao

    // fornisce tutti gli input presenti in una Request
    dump($request->all());
    dump($request->input());
    dump($request->query());

    // estrazione di un parametro specifico
    dump($request->a);
    dump($request->input('a'));

    dump($request->c); // null
    dump($request->input('c', 'Default value')); // Default value

    // Il metodo input resituisce i parametri sia di tipo GET che di tipo POST

    dump($request->query('a')); // query solo i parametri di tipo GET
    dump($request->query('c', 'Default value')); // Default value

    // Verificare la presenza di un paremtro
    dump($request->has('a')); // true
    dump($request->has('xxx')); // false
    dump($request->has(['a', 'xxx'])); // true se esistono tutti quelli elencati
    dump($request->hasAny(['a', 'xxx'])); // true se ne esiste almeno uno di quelli elencati

    $request->whenHas('a', function ($param) {
        dump('Il parametro a esiste ed ha valore ' . $param);
    });

    $request->whenHas('XXX', function ($param) {
        dump('Il parametro XXX esiste ed ha valore ' . $param);
    }, function () {
        dump('Il parametro XXX NON esiste');
    });

    // Accesso a file
    // $request->file('file_param');
    // $request->file_param;

    $request->user(); // Istanza della classe User
    // Restituisce l'utente loggato o null se non è loggato alcun utente

    dump(request());
});

Route::get('/response', function () {
    /*
    return response('Example response', 200)
        ->header('X-Application-Name', config('app.name'))
        ;
    */

    // Header multipli
    /*
    return response('Example response', 200)
        ->withHeaders([
            'X-Application-Name' => config('app.name'),
            'X-Application-Version' => '1.0.0',
        ]);
    */

    // Aggiungere cookie
    /*
    return response('Contenuto con cookie', 200)
        ->cookie('tests-cookie', 'abcde', 10);
    */
    // cookie(chiave, valore, scadenza (minuti), path, dominio, sicuro?, httpOnly)

    // Revoca cookie
    /*
    return response('Revoca cookie', 200)
        ->withoutCookie('tests-cookie');
    */

    // redirezione esplicita
    // return redirect('/dashboard');
    // return redirect()->to('/dashboard');

    // redirezione alla pagina precedente
    /*
    return back();
    return back()->withInput();
    */

    // redirect verso rotte con nome
    //return redirect()->route('dashboard');
    //return redirect()->route('example.show', ['id' => 1]);
    //return to_route('example.show', ['id' => 1]);

    // return view('tests');
    // resistuisce il contenuto (eventualmente elaborato) di un file che si chiama tests.blade.php / tests.html / tests.php
    // all'interno di resources/views

    // return view('folder.file'); // se il file cercato si trova in una cartella di nome folder (eg. folder/file.blade.php)

    // passaggio dati
    /*
    return view('tests', [
        'a' => 1,
        'b' => 'ciao'
    ]);
    */
    // all'interno della view verranno rese disponibili le variabili $a e $b con i rispettivi valori

    // Utilizzo di compact
    /*
    $a = 1;
    $b = 'ciao';
    return view('tests', compact('a', 'b'));
    */

    /*
    return view('tests')
        ->with('a', 1)
        ->with('b', 'ciao');
    */

    /*
    return response()
        ->view('tests')
        ->header('X-Application-Name', config('app.name'));
    */

    /*
    return response()->json([
        'a' => 1,
        'b' => 'ciao',
    ]);
    */

    /*
    return response()->download(
        __DIR__ . '\..\storage\app\public\tests.txt',
        'downloaded.txt'
    );
    */
    // Viene aggiunto l'header "Content-Disposition: Attachment; filename=downloaded.txt"


    return response()->file(
        __DIR__ . '\..\storage\app\public\test.txt'
    );



});


Route::get('/views', function () {
    session()->put('variable', 1);
    return view('tests.view');
});
