<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $this->success(data: $categories);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'string',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }

        Category::create($request->all());

        return $this->success('Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->success(data: $category);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'string',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors());
        }


        $category->update($request->all());

        return  $this->success('Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return  $this->success('Category deleted successfully');
    }
}
