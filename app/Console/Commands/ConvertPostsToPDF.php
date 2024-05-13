<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class ConvertPostsToPDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:to-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::all();

//        $bar = $this->output->createProgressBar($posts->count());
//        $bar->start();
//
//        foreach ($posts as $i => $post) {
//            usleep(10);
//            $bar->advance();
//            // processing
//        }
//
//        $bar->finish();





        $this->withProgressBar($posts, fn($post) => usleep(10));


        $this->newLine();
        $this->info('Export complete');


    }
}
