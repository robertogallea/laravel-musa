<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $photos = Photo::all();

        foreach ($posts as $post) {
            Comment::factory()->create([
                'commentable_type' => Post::class,
                'commentable_id' => $post->id
            ]);
        }

        foreach ($photos as $photo) {
            Comment::factory()->create([
                'commentable_type' => Photo::class,
                'commentable_id' => $photo->id
            ]);
        }
    }
}
