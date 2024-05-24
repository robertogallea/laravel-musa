<?php

namespace App\Http\Controllers\Admin;

use App\Events\PostCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Pagina /posts/index {user_id}', ['user_id' => \request()->user()->id]);
        $posts = Post::with('category', 'user')->withTrashed()->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
//        if ($request->user()->cannot('create', Post::class)) {
//            abort(404);
//        }
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
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $request->slug,
            'user_id' => $request->user()->id, // id utente loggato all'applicazione
            'category_id' => $request->category_id,
        ]);

        event(new PostCreated($post));
//        Event::dispatch(new PostCreated($post)); // in alternativa a event()

        $request->session()->flash('message', 'Post inserito con successo');
        $request->session()->flash('status', 'success');

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

        // allows e denies restituiscono solo vero o falso in base alla autorizzazione ad eseguire l'azione
//        if (Gate::denies('delete-post', $post)) {
//            abort(403);
//        }
//            inspect restituisce un oggetto di tipo response che contiene anche informazioni aggiuntive
//        $response = Gate::inspect('delete-post', $post);
//
//        if ($response->denied()) {
//            abort(401, $response->message());
//        }



        if ($post->trashed()) {
            Gate::authorize('forceDelete', $post);
            $post->forceDelete();
        } else {
            Gate::authorize('delete', $post);
            $post->delete();
        }

        return redirect(route('admin.posts.index'));

    }

    public function restore(string $post)
    {
        Post::onlyTrashed()->where('slug', $post)->first()->restore();

        return redirect(route('admin.posts.index'));
    }

}
