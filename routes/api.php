<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return UserResource::make($request->user()
        ->load('posts')
        ->loadMax('posts', 'created_at')
    );
//    return new UserResource($request->user()); // analogamente
})->middleware('auth:sanctum');


Route::post('/login', \App\Http\Controllers\Api\LoginController::class);
Route::post('/logout', \App\Http\Controllers\Api\LogoutController::class)
    ->middleware('auth:sanctum');


Route::get('/posts', [\App\Http\Controllers\Api\PostController::class, 'index'])
    ->middleware('auth:sanctum');

Route::get('/posts/{post}', [\App\Http\Controllers\Api\PostController::class, 'show'])
    ->middleware(['auth:sanctum', 'ability:show-post,view-post']);
