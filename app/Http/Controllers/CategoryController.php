<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \DB::table('categories as c1')->
            leftJoin('categories AS c2', 'c2.id', '=', 'c1.parent_category_id')->
            select('c1.id', 'c1.name', 'c2.name as parent_category')->get();
        return $categories;
    }
    
    public function list()
    {
        $categories = Category::select("id as value", "name as text")->get();
        return $categories;
    }

    public function create(Request $request)
    {
        $category = new Category([
            'name' => $request->input('name'),
            'parent_category_id' => $request->input('parent_category_id'),
        ]);
        $category->save();

        return response()->json('The category successfully added');
    }

    public function show($id)
    {
        $category = Category::get($id);
        return array_reverse($category);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->all());

        return response()->json('The category successfully updated');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json('The category successfully deleted');
    }
}
