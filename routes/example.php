<?php


use App\Models\Post;

Route::get('/no-chunk', function () {
    $result = '';

    $posts = \App\Models\Post::all();

    foreach ($posts as $post) {
        $result .= $post->title . '<br>';
    }

    return $result;
});


Route::get('/chunk', function () {
    $result = '';

    \App\Models\Post::chunk(100, function ($posts) use (&$result) {
        foreach ($posts as $post) {
            $result .= $post->title . '<br>';
        }
    });


    return $result;
});

Route::get('lazy-chunk', function () {
    $result = '';

    $posts = \App\Models\Post::lazyById(100, 'id');

    foreach ($posts as $post) {
        $result .= $post->title . '<br>';
    }

    return $result;
});

Route::get('first-or-create', function () {

    // firstOrCreate se il modello non esiste lo crea e lo salva sul db
    // firstOrNew se il modello non esiste lo crea ma NON lo salva sul db

    $model = App\Models\Post::firstOrCreate(
        [
            'title' => 'post che non esiste'
        ],
        [
            'slug' => 'aaa',
            'status' => true,
            'body' => 'aaa',
            'user_id' => 1,
            'category_id' => 1,
        ]);

    return $model;

    // update


    \App\Models\Post::find(1);

    $post->title = '....';
    $post->body = '...';
    $post->save();

    // oppure

    $post->update([
        'title' => '....',
        'body' => '...',
    ]);



    // delete

    // cancellazione a partire dal modello
    $post = \App\Models\Post::first();
    $post->delete();

    // cancellazione a partire dalla query
    \App\Models\Post::orderBy('id')->take(1)->delete();
//    'DELETE FROM posts ORDER BY id ASC LIMIT 0,1'
//    Post::destroy(1); // elimina un modello passando uno o più id
//    Post::destroy(1, 2, 3); // elimina un modello passando uno o più id
//    Post::destroy([1, 2, 3]); // elimina un modello passando uno o più id

});

Route::get('/session-get', function (\Illuminate\Http\Request $request) {
//    return $request->session()->get('test');
//    return $request->session()->get('test', 'default value');
//    return $request->session()->get('test', fn() => rand(10,100));
//    return session()->get('test', 'valore default');
    return session('test', 'valore default');
})->middleware(\Illuminate\Session\Middleware\StartSession::class);

Route::get('/session-push', function (\Illuminate\Http\Request $request) {
//   $request->session()->push('post.temp_title', 'Hello');

   return $request->session()->get('post');
})->middleware(\Illuminate\Session\Middleware\StartSession::class);

Route::get('/session-increment', function (\Illuminate\Http\Request $request) {
    $request->session()->increment('page-views');

    return $request->session()->get('page-views');
})->middleware(\Illuminate\Session\Middleware\StartSession::class);


Route::get('/cache', function() {
    $result = \Cache::remember('post_titles', 60*60*24*7, function () {
        dump('Cache ricalcolata');
        $result = '';
        $posts = Post::all();

        foreach ($posts as $post) {
            $result .= $post->title . '</br>';
        }

        return $result;
    });

    // senza scadenza
//    $result = \Cache::rememberForever('post_titles', function () {
//        dump('Cache ricalcolata');
//        $result = '';
//        $posts = Post::all();
//
//        foreach ($posts as $post) {
//            $result .= $post->title . '</br>';
//        }
//
//        return $result;
//    });
//
//    // scades solo se esplicitamente chiavo
//    \Cache::forget('post_titles');
//
//
//
//
//    return $result;
});
