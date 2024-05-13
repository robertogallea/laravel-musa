<?php

Route::get('/artisan', function() {
   \Illuminate\Support\Facades\Artisan::call('blog:to-pdf');
});

Route::get('/artisan-1', function() {
    \Illuminate\Support\Facades\Artisan::call('blog:post-info', [
        'post_id' => 1
    ]);
});


Route::get('/collection/each', function() {
    $titles = '';
    $posts = \App\Models\Post::all();

    $posts->each(function($post) use (&$titles) {
        $titles .= $post->title . '<br>';
    });

    return $titles;
});

Route::get('/collection/map', function() {
    $posts = \App\Models\Post::withCount('likes')->get();

    $titlesAndLikes = $posts->map(
        fn($post) => [
            'title' => $post->title,
            'likes' => $post->likes_count
        ]
    );
    dd($titlesAndLikes);
});

Route::get('/collection/ex1', function() {
    $posts = \App\Models\Post::withCount('likes')->get();

    // calcolare il numero totale di like per i post
    // il cui titolo è superiore ai 20 caratteri

    $likesSum = $posts
        ->filter(fn($post) => strlen($post->title) > 20)
        ->sum('likes_count');
    dd($likesSum);

});

Route::get('/collection/ex2', function() {
    $posts = \App\Models\Post::withCount('likes')->get();
    dump($posts);

    // raggruppamento sullo stato di ciascun elemento della collection
    $postsGroups = $posts->groupBy('status');
    dump($postsGroups);

    // raggruppamento in base alla lunghezza del titolo di ciascun elemento della collection (post)
    $postsGroups2 = $posts->groupBy(function($post) {
       // raggruppare per numero di caratteri del titolo
        return strlen($post->title);
    });

    dump($postsGroups2);

    // raggruppamento di secondo livello, sulla divisibilità per 2 della lunghezza dei titoli
    $postsGroupsOddEven = $postsGroups2->groupBy(fn($item, $key) => $key % 2);
    dd($postsGroupsOddEven);
});


Route::get('/collection/ex3', function() {
    // prendo tutti i post finchè non ne incontro uno che abbia almeno un like
    $posts = \App\Models\Post::withCount('likes')->get();

    $posts = $posts->takeUntil(fn($post) => $post->likes_count > 0);

    dd($posts);
});

Route::get('/collection/macro', function() {
    $posts = \App\Models\Post::all();

    dd($posts->groupByTitleDivisibleBy(5));
});



// Higher order messages
Route::get('/collection/high-order-messages', function() {
    // Estrazione dei titoli dei post
    $posts = \App\Models\Post::with('category')->withCount('likes')->get();

//    $titlesAndLikes = $posts->map(fn($post) => $post->title);
    $titlesAndLikes = $posts->map->title;
    dump($titlesAndLikes);

    $titlesByStatus = $posts->groupBy->status;
    dump($titlesByStatus);

    $titlesSortedByCreatedAt = $posts->sortBy->created_at->map->title;
    dump($titlesSortedByCreatedAt);

});
