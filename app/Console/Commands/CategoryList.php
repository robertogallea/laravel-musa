<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;

class CategoryList extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:categories';

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
        // eager loading del conteggio della relazione posts
        $categories = Category::withCount('posts')->get();
//        $categories = dd(Category::withMax('posts', 'created_at')->toSql());

        $this->info(strtoupper("Elenco delle categorie:"));
        foreach ($categories as $i => $category) {
//            $this->info('[' . ($i+1) . '] ' .  $category->label . '(' . $category->posts()->count() . ')'); // usando lazy loading
            $this->info('[' . ($i+1) . '] ' .  $category->label . '(' . $category->posts_count . ')'); // usando eager loading
        }
//        $this->info('The command works');
//        $this->warn('Warning message');
//        $this->error('Error message');

//        NOTA SUL CONTEGGIO
//        $category->posts->count;
//        $posts = $category->posts // è la collezione di oggetti
//        $posts->count(); // metodo di Collection che conta il numero di oggetti
//
//        $category->posts()->count() // equivale a fare una query SELECT count(*) FROM posts WHERE post.category_id = ?

    }
}
