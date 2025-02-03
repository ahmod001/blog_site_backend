<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
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
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'content' => 'required',
            'post_slug' => 'required',
        ]);

        if ($validation->fails())
            return response()->json($validation->errors(), 422);

        $post = Post::slug($request->input('post_slug'))->first();

        if ($post) {
            Comment::create([
                'content' => $request->content,
                'post_id' => $post->id,
                'user_id' => $request->user()->id
            ]);

            return $this->success('Comment created successfully');
        }

        return $this->failed('No post found', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return $this->success(data: $comment->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validation = Validator::make($request->all(), [
            'content' => 'required',
            'post_slug' => 'required|string',
        ]);

        if ($validation->fails())
            return response()->json($validation->errors(), 422);

        if ($request->user()->id !== $comment->user_id)
            return $this->failed('Unauthorized', 403);


        $post = Post::slug($request->input('post_slug'))->first();

        if ($post) {
            $comment->update([
                'content' => $request->content,
            ]);

            return $this->success('Comment updated successfully');
        }
        return $this->failed('No post found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id)
            return $this->failed('Unauthorized', 403);

        $comment->delete();
        return $this->success('Comment deleted successfully');
    }
}
