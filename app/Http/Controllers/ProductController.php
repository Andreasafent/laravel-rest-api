<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Str;
use Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        //Select * FROM products

        return response()->json([
            "message" => "List of products",
            "products" => $products
        ]);
    }
    public function create(Request $request){

        $validated = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'max:255',
            'price' => 'required|decimal:0,2|max:99999999.99|min:0.01',
            'image' => 'url:http,https'
        ]);

        if ($validated->fails()){
            return response()->json([
                'message'=> 'Validation failed',
                'errors' => $validated->errors()
            ]);
        };


        $slug = Str::slug($request->title);
        $existedProduct = Product::where("slug", $request->slug)->first();

        if($existedProduct){
            return response()->json([
                "message" => "Product already exists",
                "errors"=> [
                    "slug"=> "Product with this slug already exists"
                ]   
            ], 400);
        }


        $product = Product::create([
            "title" => $request->title,
            "description"=> $request->description,
            "price"=> $request->price,
            "image"=> $request->image,
            "slug"=> $slug
        ]);

        return response()->json([
            "message" => "Product created",
            "data" => $request->all()
        ], 201);;
    }
    public function show($id){
        $product = Product::find($id);
        if($product === null){
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        return response()->json([
            "message" => "Product found",
            "product" => $product
        ]);
    }
    public function update(Request $request, $id){
        $product = Product::find($id);
        if($product === null){
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        $product->update($request->all());

        return response()->json([
            "message" => "Product with id: $id updated",
        ]);
    }
    public function delete($id){
        $product = Product::find($id);
        if($product === null){
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }
        $product->delete();
        return response()->json([
            "message" => "Product with id: $id deleted"
        ]);
    }
}
