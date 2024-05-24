<?php

use Illuminate\Support\Facades\Storage;

Route::get('/download', function () {
    return Storage::download(
        'test.json',
        'downloaded.json',
        [
            'Content-Disposition' => 'inline' // Mostra il contenuto del file direttamente nel browser
        ]
    );
});


Route::view('/upload-form', 'upload-form');

Route::post('/upload', function (\Illuminate\Http\Request $request) {

//    $originalName = $request->file('uploadedFile')->getClientOriginalName(); // Per ottenere il nome originale del file

    $filename = $request->file('uploadedFile')->store('images'); // salva il file con nome casuale

//   $filename = $request->file('uploadedFile')->storeAs('images','my-image.jpg'); // specifico il nome da assegnare al file
    return $filename;

    // Esempio di memorizzazione di file originale e file dell'applicazione per successivo download con il nome originale
    // Supponendo di avere una classe Picture
//    Picture::create([
//        'original_name' => $originalName,
//        'filename' => $filename,
//    ]);
//
//    $picture = Picture::find(1);
//    Storage::download($picture->filename, $picture->original_name);
});



Route::view('/components', 'component-example', ['numberOfIterations' => 10, 'componentName' => 'TestComponent']);
