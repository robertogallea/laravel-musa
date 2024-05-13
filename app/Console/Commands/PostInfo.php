<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Str;
use function Laravel\Prompts\password;
use function Laravel\Prompts\search;
use function Laravel\Prompts\suggest;

class PostInfo extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'blog:post-info {post_id}';
    protected $signature = 'blog:post-info {post_id* : The ID(s) of the post}'; // post_id array
//    protected $signature = 'blog:post-info {post_id?}'; // post_id opzionale
//    protected $signature = 'blog:post-info {post_id=1}'; // post_id con valore di default 1

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command shows a post information';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $postIds = $this->argument('post_id');
        foreach ($postIds as $postId) {
            $post = Post::find($postId);
            if ($post) {
                $this->info('Title: ' . $post->title);
                $this->info('Category: ' . $post->category->label);
                $this->info('Summary: ' . $post->summary);
            } else {
                $this->error("The post with id {$postId} does not exist");
            }
            $this->comment('------------------------------');
        }

    }

    protected function promptForMissingArgumentsUsing()
    {
//        E' possibile definire un messaggio da presentare all'utente
//        return [
//            'post_id' => 'Please insert the ID of the post'
//        ];

//        return [
//            'post_id' => [
//                'Please insert the ID of the post', 'E.g. 123'
//            ]
//        ];

        return [
            'post_id' => fn() => search(
                label: 'Search for a post',
                placeholder: 'E.g. 123',
                options: fn($value) => strlen($value) > 2
                    ? Post::where('title', 'like', '%' . $value . '%')->pluck('title', 'id')->all()
                    : []
            ),
        ];
    }


}
