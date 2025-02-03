<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'published' => 'boolean',
            'category_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(),422);
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'published' => $request->published,
            'category_id' => $request->category_id,
            'author_id' => $request->user()->id(),
        ]);

        return $this->success('Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->success(data: $post->load('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $user = $request->user();

        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'published' => 'boolean',
            'category_id' => 'required|integer',
        ]);


        if (!$post->is_authorized($user->id))
            return $this->failed('Unauthorized', 401);
        if ($validation->fails())
            return response()->json($validation->errors(),422);

        $post->update($request->all());
        return $this->success('Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        if (!$post->is_authorized($request->user()->id))
            return $this->failed('Unauthorized', 401);

        $post->delete();

        return $this->success('Post deleted successfully');
    }
}
