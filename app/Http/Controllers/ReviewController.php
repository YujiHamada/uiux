<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

use App\Review;
use App\Category;
use App\Review_Category;
use App\Review_Agree;

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
        //賛成・反対を取得。存在しなくても存在しないということをview側で必要なので必ず渡す
        $agree = Review_Agree::where('review_id', $reviewId)->where('user_id', Auth::user()->id)->first();

        return view('review.show', compact('review', 'agree'));
    }

    //投稿用
    public function create() {
        $categories = Category::take(10)->get();
        $categoryNames = DB::table('categories')->where('is_master', 1)->orderBy('name', 'asc')->pluck('name');
        //カテゴリーをjquery autocompleteで使えるよう"hoge", "hoge"の形にする
        $categoryNames = '"' .implode('","',$categoryNames->all()) . '"';
        return view('review.create',compact('categories', 'categoryNames'));
    }

    //投稿確認画面表示用
    public function confirm(\App\Http\Requests\StoreReviewPost $request){
        $description = $request->input('description');
        $title = $request->input('title');
        $file = $request->file('uiImage');
        $url = $request->input('url');
        $good_or_bad = $request->input('good_or_bad');
        $selectedCategories = $request->input('categories');

        //ファイル名はmd5で暗号化したものに元の拡張子をつける
        if($file){
            $fileName = md5($file->getClientOriginalName()) . '.' .$file->getClientOriginalExtension();
            $file->move(\Config::get('const.TEMPORARY_IMAGE_FILE_DIRECTORY'), $fileName);
        }
        return view('review.confirm', compact('title', 'description', 'fileName', 'url', 'good_or_bad', 'selectedCategories'));
    }

    //投稿完了画面表示用
    public function store(Request $request){
        //リクエストから値の取得
        $description = $request->input('description');
        $title = $request->input('title');
        $fileName = $request->input('fileName');
        $url = $request->input('url');
        $good_or_bad = $request->input('good_or_bad');

        $parseUrl = parse_url($url);
        $domain = "";
        if(isset($parseUrl['host'])){
            $domain = $parseUrl['host'];
        }


        $user = Auth::user();
        $user_id = $user->id;

        //画像を一時フォルダから保存用フォルダに移動
        if($fileName){
            File::move(\Config::get('const.TEMPORARY_IMAGE_FILE_DIRECTORY') . $fileName, \Config::get('const.IMAGE_FILE_DIRECTORY') . $fileName);
        }

        //DB保存用データの作成・保存
        $review = new Review;
        $review->title = $title;
        $review->description = $description;
        $review->image_name = $fileName;
        $review->url = $url;
        $review->domain = $domain;
        $review->good_or_bad = $good_or_bad;
        $review->user_id = $user_id;

        $review->save();

        $this->categorize($request->input('categories'), $review->id);

        return redirect('/')->with('flash_message', '投稿が完了しました');
    }

    public function categorize($categories, $reviewId){
        $reviewCategories = array();
        foreach($categories as $key => $categoryName){
            $savedCategory = Category::where('name', $categoryName)->first();
            $categoryId;
            if(!empty($savedCategory->id)){
                $categoryId = $savedCategory->id;
            }else{
                $category = new Category;
                $category->name = $categoryName;
                $category->save();

                $categoryId = $category->id;
            }
            array_push($reviewCategories, array('category_id' => $categoryId, 'review_id' => $reviewId, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
        }
        DB::table('review_category')->insert($reviewCategories);
    }

    public function agree(Request $request){

        $reviewAgree = Review_Agree::where('review_id', $request->review_id)->where('user_id', Auth::user()->id)->first();

        if($reviewAgree){
            //すでにレビューに対する評価があったらその評価を削除して削除フラグを返却する
            Review_Agree::where('review_id', $request->review_id)->where('user_id', Auth::user()->id)->delete();
            return response()->json([
                'isDeleted' => '1'
            ]);
        }else{
            //まだ未評価の場合、評価を保存する。
            $isAgree = $request->agree;

            $reviewAgree = new Review_Agree;
            $reviewAgree->user_id = $request->user_id;
            $reviewAgree->review_id = $request->review_id;
            $reviewAgree->is_agree = $isAgree;

            $reviewAgree->save();

            return response()->json([
                'isAgree' => $isAgree
            ]);
        }
    }
}
