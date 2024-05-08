<?php

Route::get('/', function() {
    return 'admin route';
})
->middleware(['magic:' . config('app.magic_number')])
->name('index');  // route('admin.index')

Route::resource('/posts', \App\Http\Controllers\Admin\PostController::class);
Route::put('/posts/{post}/restore', [\App\Http\Controllers\Admin\PostController::class, 'restore'])->name('posts.restore');

Route::get('/show', function() {
    return 'show';
})->name('show');  // route('admin.show')
