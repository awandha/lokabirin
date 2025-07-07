<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return Post::all();
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'title'   => $request->title,
            'content' => $request->content,
            'slug'    => $request->slug,
            'user_id' => auth()->id(),
        ]);

        return response()->json($post, 201);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->validated());

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}
