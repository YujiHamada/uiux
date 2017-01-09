<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Review;

class ReviewController extends Controller
{
    // public $temporaryImageFileDirectory = 'images/temporary/review_image/';
    // public $imageFileDirectory = 'images/review_image/';
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
    //表示用
    public function show($reviewId){
        $review = Review::findOrFail($reviewId);
        return view('review.show', compact('review'));
    }

    //投稿用
    public function create() {
      return view('review.create');
    }

    //投稿確認画面表示用
    public function confirm(Request $request){
        $description = $request->input('description');
        $title = $request->input('title');
        $file = $request->file('uiImage');

        //ファイル名はmd5で暗号化したものに元の拡張子をつける
        $fileName = md5($file->getClientOriginalName()) . '.' .$file->getClientOriginalExtension();

        $file->move(\Config::get('const.TEMPORARY_IMAGE_FILE_DIRECTORY'), $fileName);
        $filePath = \Config::get('const.IMAGE_FILE_DIRECTORY') . $fileName;

        return view('review.confirm', compact('title', 'description', 'filePath', 'imageFileDirectory', 'fileName'));
    }

    //投稿完了画面表示用
    public function store(Request $request){
        //リクエストから値の取得
        $description = $request->input('description');
        $title = $request->input('title');
        $fileName = $request->input('fileName');

        //画像を一時フォルダから保存用フォルダに移動
        File::move(\Config::get('const.TEMPORARY_IMAGE_FILE_DIRECTORY') . $fileName, \Config::get('const.IMAGE_FILE_DIRECTORY') . $fileName);

        //DB保存用データの作成・保存
        $review = new Review;
        $review->title = $title;
        $review->description = $description;
        $review->image_name = $fileName;
        $review->save();

        return redirect('/')->with('flash_message', '投稿が完了しました');
    }
}
