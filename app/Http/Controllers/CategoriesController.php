<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Auth;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all categories from database
        $categories = Category::all();
        return response()->json($categories);
    }

    public function showBooksInCat(Request $request, $id)
    {
        $category = Category::with('books')->find($id);

        $books  = [];

        foreach ($category->books as $key => $val) {

            $books[$key] = $val;
            $books[$key]['file_url'] = url('uploads/' . $val->file_id . '.pdf'); 

        }

        return response()->json($books);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Using POST request
        // Store all categories to database

        $this->validate($request, [
            'category_name' => 'required|unique:categories'
        ]);

        $category = new Category();

        $category->category_name = $request->input('category_name');

        $category->save();
        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get category by ID 
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' => ['required',
            Rule::unique('categories')->ignore($id)]
        ]);

        $category = Category::find($id);

        $category->category_name = $request->input('category_name');

        $category->save();
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete category by ID
        $category = Category::find($id);
        $category->delete();
        return response()->json('Category deleted successfully!');
    }
}

