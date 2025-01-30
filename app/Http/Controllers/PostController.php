<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
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
            'is_published' => 'boolean',
            'category_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_published' => $request->published,
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
