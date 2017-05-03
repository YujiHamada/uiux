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
use App\Tag;
use App\Review_Tag;
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
    public function create(Request $request,$reviewId = null) {
        $review;
        if(!empty($reviewId)){
            $review = Review::findOrFail($reviewId);
        }
        $tags = Tag::take(10)->get();
        $tagNames = DB::table('tags')->where('is_master', 1)->orderBy('name', 'asc')->pluck('name');
        //タグをjquery autocompleteで使えるよう"hoge", "hoge"の形にする
        $tagNames = '"' .implode('","',$tagNames->all()) . '"';

        return view('review.create',compact('tags', 'tagNames', 'review', 'reviewId'));
    }

    //投稿完了画面表示用
    public function store(\App\Http\Requests\StoreReviewPost $request){
        //リクエストから値の取得

        $reviewId = $request->input('reviewId');
        $description = $request->input('description');
        $title = $request->input('title');
        $file = $request->file('uiImage');
        $url = $request->input('url');
        $good_or_bad = $request->input('good_or_bad');

        $parseUrl = parse_url($url);
        $domain = "";
        if(isset($parseUrl['host'])){
            $domain = $parseUrl['host'];
        }

        $user = Auth::user();
        $user_id = $user->id;

        $fileName;
        if($file){
            $fileName = md5($file->getClientOriginalName()) . '.' .$file->getClientOriginalExtension();
            $file->move(\Config::get('const.IMAGE_FILE_DIRECTORY'), $fileName);
        }

        //DB保存用データの作成・保存
        $review;
        if(!empty($reviewId)){
            $review = Review::find($reviewId);
        }else{
            $review = new Review;
        }
        $review->title = $title;
        $review->description = $description;
        if(isset($fileName)){
            $review->image_name = $fileName;
        }
        $review->url = $url;
        $review->domain = $domain;
        $review->good_or_bad = $good_or_bad;
        $review->user_id = $user_id;

        $review->save();

        $this->insertReviewTag($request->input('tags'), $review->id);

        return redirect('/')->with('flash_message', '投稿が完了しました');
    }

    public function insertReviewTag($tags, $reviewId){
        $reviewTags = array();
        foreach($tags as $key => $tagName){
            $savedTag = Tag::where('name', $tagName)->first();
            $tagId;
            if(!empty($savedTag->id)){
                $tagId = $savedTag->id;
                if(count(Review_Tag::where(['review_id' => $reviewId], ['tag_id' => $tagId])->first()) != 0){
                    //同じレビューID、タグIDが存在したらinsertしない
                    continue;
                }
            }else{
                $tag = new Tag;
                $tag->name = $tagName;
                $tag->save();

                $tagId = $tag->id;
            }
            array_push($reviewTags, array('tag_id' => $tagId, 'review_id' => $reviewId, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
        }
        DB::table('review_tag')->insert($reviewTags);
    }

    public function agree(Request $request){

        $reviewAgree = Review_Agree::where('review_id', $request->review_id)->where('user_id', Auth::user()->id)->first();

        if($reviewAgree){
            //すでにレビューに対する評価があったらその評価を削除して削除フラグを返却する
            Review_Agree::where('review_id', $request->review_id)->where('user_id', Auth::user()->id)->delete();
            return response()->json([
                'isDeleted' => true
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

    public function delete($id){
        DB::table('reviews')->where(['id' => $id])->delete();
        return redirect('/')->with('flash_message', 'レビューの削除が完了しました');
    }
}
