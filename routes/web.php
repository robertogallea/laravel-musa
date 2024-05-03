<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
})->middleware(['highlight']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Route::[verb](path, handler);

// verb
// - get        Visualizzare una risorsa
// - post       Salvare una nuova risorsa
// - put        Aggiornare una risorsa esistente - sempre idempotente
// - patch      Aggiornare una risorsa esistente - non necessariamente idempotente
// - delete     Eliminare una risorsa

// Rotta per un verbo specifico
Route::get('/test', function () {
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
Route::redirect('/redirect', '/test');

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
});

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

// SELECT * FROM users WHERE email = 'test@test.it';

// MISSING BINDING
Route::get('/users3/{user}', function (User $user) {
    dd($user);
})->missing(function () {
    return redirect('/');
    // Nel caso in cui non sia possibile effettuare il binding
    // è possibile fare un redirect invece di fornire errore 404
});




Route::get('/posts/{post}', [\App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'show']);



// FALLBACK ROUTE
Route::fallback(function () {
    return 'Fallback route';
});

require __DIR__.'/auth.php';
