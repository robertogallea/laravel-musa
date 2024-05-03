<?php

Route::get('/', function() {
    return 'admin route';
})
->middleware(['magic:' . config('app.magic_number')])
->name('index');  // route('admin.index')

Route::get('/show', function() {
    return 'show';
})->name('show');  // route('admin.show')
