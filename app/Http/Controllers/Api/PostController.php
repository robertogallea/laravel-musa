<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
//        if ($request->user()->tokenCan('posts.index')) {
            $posts = Post::withTrashed()
                ->with('user')
                ->withCount('likes')
                ->paginate();

//            return response()->json($posts); // usa il metodo toArray() della classe post
            return PostResource::collection($posts); // trasforma ogni modello Post secondo lo schema definito in PostResource
//        }

        return response()->json(['message' => 'Non hai accesso a questa risorsa']);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }
}
