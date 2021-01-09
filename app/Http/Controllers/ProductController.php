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
        $product = new Product();
        $requestData = $request->all();
        if($request->hasFile('image')){
            $generated_new_name = $this->uploadImage($request->image);
            $requestData['image'] = $generated_new_name;
        }
        $product->insert($requestData);

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
        $requestData = $request->all();
        if($request->hasFile('image')){
            $generated_new_name = $this->uploadImage($request->image);
            $requestData['image'] = $generated_new_name;
        }
        $product->update($requestData);
        return response()->json('The product successfully updated');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json('The product successfully deleted');
    }

/** HELPERS */

    private function uploadImage($image){
        $upload_path = public_path('upload');
        $file_name = $image->getClientOriginalName();
        $generated_new_name = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move($upload_path, $generated_new_name);
        return $generated_new_name;
    }

/** END HELPERS  */
}
