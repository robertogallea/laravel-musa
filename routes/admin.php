<?php

Route::get('/', function() {
    return 'admin route';
})
->middleware(['magic:' . config('app.magic_number')])
->name('index');  // route('admin.index')

Route::get('/posts/create', [\App\Http\Controllers\Admin\PostController::class, 'create'])->name('posts.create')->middleware('can:create,App\Models\Post');
Route::delete('/posts/{post}', [\App\Http\Controllers\Admin\PostController::class, 'delete'])->name('posts.delete')->middleware('can:destroy,post');
Route::get('/posts', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('posts.index')->middleware('can:viewAny,App\Models\Post');
Route::get('/posts/{post}', [\App\Http\Controllers\Admin\PostController::class, 'show'])->name('posts.show')->middleware('can:view,post');
Route::get('/posts/{post}/edit', [\App\Http\Controllers\Admin\PostController::class, 'edit'])->name('posts.edit')->middleware('can:update,post');
Route::post('/posts', [\App\Http\Controllers\Admin\PostController::class, 'store'])->name('posts.store')->middleware('can:create,post');
Route::put('/posts/{post}', [\App\Http\Controllers\Admin\PostController::class, 'update'])->name('posts.update')->middleware('can:update,post');

Route::delete('/posts/{post}', [\App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('posts.destroy')->withTrashed(); // definisco la rotta manualmente per consentire l'utilizzo di modelli trashed()
//

Route::put('/posts/{post}/restore', [\App\Http\Controllers\Admin\PostController::class, 'restore'])->name('posts.restore');

Route::get('/show', function() {
    return 'show';
})->name('show');  // route('admin.show')
