<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class PostList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:posts
                                {--C|with-category : Whether to include category label or not}
                                {--L|with-likes : Whether to include # of likes or not}';
//                                {--L|with-likes=* : Whether to include # of likes or not}'; // in questo caso l'opzione è definita come array

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Provides the list of the posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $withCategory = $this->option('with-category');
        $withLikes = $this->option('with-likes');

//        the generic way
//        if ($withCategory) {
//            $posts = Post::with('category')->get();
//        } else {
//            $posts = Post::all();
//        }

//        the laravel way
        $posts = Post::query()
            ->when($withCategory, fn($q) => $q->with('category'))
            ->when($withLikes, fn($q) => $q->withCount('likes'))
            ->get();

//        foreach ($posts as $post) {
//            $postInfo = $post->title;
//            if ($withCategory) {
//                $postInfo .= '(category=' . $post->category->label . ')';
//            }
//            if ($withLikes) {
//                $postInfo .= '(# likes=' . $post->likes_count . ')';
//            }
//            $this->info($postInfo);
//        }
        $this->table(
            ['Title', '# likes'],
            $posts->select(['title', 'likes_count'])
        );
    }
}
