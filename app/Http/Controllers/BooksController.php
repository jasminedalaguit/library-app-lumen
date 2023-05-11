<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all books from database
        $books = Book::with('category')->get();
        // $mybooks=[];
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
        // Store all books to database

        $this->validate($request, [
            'book_title' => 'required|unique:books',
            'author' => 'required',
            'category_id' => 'required|numeric:books',
            'file_id' => 'required'
        ]);

        $filename = $request->input('file_id') . '.pdf';
        if(!Storage::disk('local')->exists('uploads/'. $filename)) {
       
            return response()->json('File not found.', 422);
        } 
    
        // $file_name = Str::kebab($request->book_title . '.pdf');
        
        $book = new Book();
            
        // text data
        $book->book_title = $request->input('book_title');
        $book->author = $request->input('author');
        $book->category_id = $request->input('category_id');
        $book->file_id = $request->input('file_id');

        $book->save();
        return response()->json(['id'=>$book->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get book by ID
        $book = Book::find($id);
        return response()->json($book);
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
        // Update book by ID 

        $this->validate($request, [
            'book_title' => ['required', Rule::unique('books')->ignore($id)],
            'author' => 'required',
            'category_id' => 'required',
            'file_id' => 'required',
        ]);

        $filename = $request->input('file_id') . '.pdf';
        if(!Storage::disk('local')->exists('uploads/'. $filename)) {
       
            return response()->json('File not found.');
        } 

        $book = Book::find($id);

        // text data
        $book->book_title = $request->input('book_title');
        $book->author = $request->input('author');
        $book->category_id = $request->input('category_id');
        $book->file_id = $request->input('file_id');

        $book->save();
        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete book by ID 
        $book = Book::find($id);
        $book->delete();
        return response()->json('Book deleted successfully!');
    }
}
