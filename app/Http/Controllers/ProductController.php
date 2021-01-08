<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::leftJoin('categories','categories.id','=','products.category_id')
                    ->select('products.id', 'products.name', 'products.description', 'products.price', 'categories.name as category', 'products.image')->get();
        return $products;
    }

    public function create(Request $request)
    {

        $product = new Product([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
        ]);

        if($request->hasFile('image')){
            $upload_path = public_path('upload');
            $file_name = $request->image->getClientOriginalName();
            $generated_new_name = uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($upload_path, $generated_new_name);
            $product->image = $generated_new_name;
        }
        $product->save();

        return response()->json('The product successfully added');
    }

    public function show($id)
    {
        $product = Product::get($id);
        return array_reverse($product);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');

        if($request->hasFile('image')){
            $upload_path = public_path('upload');
            $file_name = $request->image->getClientOriginalName();
            $generated_new_name = uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($upload_path, $generated_new_name);
            $product->image = $generated_new_name;
        }
        $product->save();
        return response()->json('The product successfully updated');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json('The product successfully deleted');
    }
}
