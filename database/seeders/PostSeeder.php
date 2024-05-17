<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

//        foreach (range(1,1000) as $i) {
//            Post::factory()->for($users[rand(0,9)])->create();
//        }

        Post::factory(1000)
            ->recycle($users)
            ->recycle($categories)
            ->create();
    }
}
