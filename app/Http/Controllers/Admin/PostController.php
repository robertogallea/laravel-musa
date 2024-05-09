<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category', 'user')->withTrashed()->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post = new Post();
        $categories = Category::all();
        $users = User::all();

        return view('admin.posts.create', compact('post', 'categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $request->slug,
            'user_id' => $request->user()->id, // id utente loggato all'applicazione
            'category_id' => $request->category_id,
        ]);


        return redirect(route('admin.posts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
        ]);


        return redirect(route('admin.posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

//        $post = Post::withTrashed()->where('slug', $post)->first();

        if ($post->trashed()) {
            $post->forceDelete();
        } else {
            $post->delete();
        }


        return redirect(route('admin.posts.index'));
    }

    public function restore(string $post)
    {
        Post::onlyTrashed()->find($post)->restore();

        return redirect(route('admin.posts.index'));
    }

}
