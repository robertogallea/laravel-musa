<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $posts = Post::with('category')->withTrashed()->get();

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
    public function store(Request $request)
    {
        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user()->id, // id utente loggato all'applicazione
            'category_id' => $request->category_id,
        ]);

//        $post = new Post();
//        $post->title = $request->title;
//        $post->body = $request->body;
//        $post->user_id = $request->user_id;
//        $post->category_id = $request->category_id;
//        $post->save();

        return redirect(route('admin.posts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
        ]);
        /*
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        */

        return redirect(route('admin.posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Così servono due query
//        $post = Post::find($id);
//        $post->delete();

        // in questo modo faccio una sola query
        Post::where('id', $id)->delete();

        return redirect(route('admin.posts.index'));
    }

    public function restore(string $post)
    {
        Post::onlyTrashed()->find($post)->restore();

        return redirect(route('admin.posts.index'));
    }
}
