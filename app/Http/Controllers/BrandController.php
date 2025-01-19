<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::withCount('products')->get();
        //Select * FROM brands

        return response()->json([
            "message" => "List of brands",
            "brands" => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'slug' => 'required|unique:brands,slug',
            'logo' => 'url:http,https'
        ]);

        if($validator->fails()){
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], status:400);
        }

        $brand = Brand::create([
            "name" => $request->name,
            "slug" => $request->slug,
            "logo" => $request->logo
        ]);

        return response()->json([
            "message" => "Brand created successfully",
            "brand" => $brand
        ], status:201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return response()->json([
            "message" => "Brand details",
            "brand" => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'filled|max:255',
            'slug' => 'required|unique:brands,slug',
            'logo' => 'url:http,https'
        ]);

        if($validator->fails()){
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], status:400);
        }

        $brand->update($request->all());

        return response()->json([
            "message" => "Brand updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response()->json([
            "message" => "Brand deleted successfully"
        ]);
    }
}
