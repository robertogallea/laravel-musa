<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $latestPosts = Post::latest('id')->paginate(3, ['*'], 'pageLatest')->withQueryString();

        $oldestPosts = Post::orderBy('id', 'asc')->paginate(3, ['*'], 'pageOldest')->withQueryString();


        return view('posts.index', compact('latestPosts', 'oldestPosts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
