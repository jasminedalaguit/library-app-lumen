<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function upload(Request $request){

        $this->validate($request, [
            'file' => 'required|max:30000|mimes:pdf',
        ]);

        $file=$request->file('file');
        $id=uniqid() ;
        $path=$file->storeAs('uploads',$id. '.pdf');
        return response()->json(['file_id'=>$id]);
    }
}
