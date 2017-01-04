<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Post;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //投稿画面表示用
    public function index(){
        
        
        return view('post/post');
    }

    //投稿確認画面表示用
    public function postConfirmation(Request $request){
        // $path = $request->uiImage->store('images/post');
        $description = $request->input('description');
        $title = $request->input('title');
        // $imageSrc = $request->input('imageSrc');

        $file = $request->file('uiImage');

        $fileName = md5($file->getClientOriginalName()) . '.' .$file->getClientOriginalExtension(); 
        // echo "<pre>";
        // print_r(md5($file->getClientOriginalName()));
        // echo "</pre>";

        $fileDirectory = 'images/temporary/post/' ;

        $file->move($fileDirectory, $fileName);

        $filePath = $fileDirectory . $fileName;

        return view('post/postConfirmation', compact('title', 'description', 'filePath', 'fileDirectory', 'fileName'));
    }

    //投稿完了画面表示用
    public function postCompletion(Request $request){
        //リクエストから値の取得
        $description = $request->input('description');
        $title = $request->input('title');
        $fileName = $request->input('fileName');
        $fileDirectory = $request->input('fileDirectory');

        //画像を一時フォルダから保存用フォルダに移動
        File::move($fileDirectory . $fileName, 'images/post/' . $fileName);

        //DB保存用データの作成・保存
        $post = new Post;
        $post->title = $title;
        $post->description = $description;
        $post->image_url = 'images/post/' . $fileName;

        $post->save();

        return view('post/postCompletion');
    }

    public function viewPost(){
        $id = Input::get('id');

        $post = Post::find($id);

        return view('post/viewPost', compact('post'));
    }
}
