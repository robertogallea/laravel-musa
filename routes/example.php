<?php


Route::get('/lang', function(\Illuminate\Http\Request $request) {
   return view('examples.lang');
});

Route::get('/lang2', function(\Illuminate\Http\Request $request) {
    return __('messages.confirmation');
});
