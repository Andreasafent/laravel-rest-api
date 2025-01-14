<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->all();
        //Select * FROM categories

        return response()->json([
            "message" => "List of categories",
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'max:500',
            'slug' => 'required|unique:categories,slug'
        ]);

        if ($validator->fails()){
            return response()->json([
                'message'=> 'Validation failed',
                'errors' => $validator->errors()
            ], status:400);
        };

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $request->slug
        ]);

        return response()->json([
            "message" => "Category created successfully",
            "category" => $category
        ], status:201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        return response()->json([
            "message" => "Category details",
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'filled|max:255',
            'description' => 'max:500',
            'slug' => 'filled|unique:categories,slug,'. $category->id
        ]);

        if ($validator->fails()){
            return response()->json([
               'message'=> 'Validation failed',
                'errors' => $validator->errors()
            ], status:400);
        };

        $category->update($request->all());

        return response()->json([
            "message" => "Category updated successfully",
            "category" => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            "message" => "Category deleted successfully"
        ]);
    }
}
