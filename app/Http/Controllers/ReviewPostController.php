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
use App\ReviewTag;
use App\SummaryTag;
use App\SummaryScore;
use App\ReviewEvaluation;
use App\Libs\Scraping;

class ReviewPostController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    //表示用
    public function show($reviewId){
        $review = Review::findOrFail($reviewId);
        //賛成・反対を取得。存在しなくても存在しないということをview側で必要なので必ず渡す
        $evaluation = ReviewEvaluation::where('review_id', $reviewId)->where('user_id', Auth::user()->id)->first();

        return view('review.post.show', compact('review', 'evaluation'));
    }

    //投稿用
    public function create($reviewId = null) {

      if(!empty($reviewId)){
          $review = Review::findOrFail($reviewId);
      }
      $tagNames = DB::table('tags')->where('is_master', 1)->orderBy('name', 'asc')->pluck('name');
      //タグをjquery autocompleteで使えるよう"hoge", "hoge"の形にする
      $tagNames = '"' .implode('","',$tagNames->all()) . '"';

      return view('review.post.create',compact('tagNames', 'review'));
    }

    //投稿完了画面表示用
    public function store(\App\Http\Requests\StoreReviewPost $request){

      $userId = Auth::user()->id;
      $description = $request->input('description');
      $title = $request->input('title');
      $type = $request->input('type');

      $file = $request->file('uiImage');
      if($file) {
        $fileName = md5($file->getClientOriginalName()) . '.' .$file->getClientOriginalExtension();
        $file->move(\Config::get('const.IMAGE_FILE_DIRECTORY'), $fileName);
      } else {
        $fileName = null;
      }

      $url = $request->input('url');
      if(!empty($url)){
        $parseUrl = parse_url($url);
        $domain = $parseUrl['host'];
      } else {
        $url = null;
        $domain = null;
      }

      $og = Scraping::ogp($url);

      $review = Review::create([
                    'user_id' => $userId,
                    'type' => $type,
                    'title' => $title,
                    'description' => $description,
                    'url' => $url,
                    'image_name' => $fileName,
                    'domain' => $domain,
                    'is_request' => false,
                    'url_title' => $og['title'],
                    'url_description' => $og['description'],
                    'url_image' => $og['fileName'],
                  ]);

      // タグが設定されている場合は保存処理を行う。
      $reviewTagNames = $request->input('review_tag_names');
      if(!is_null($reviewTagNames)) {
        Tag::insertReviewTag($reviewTagNames, $review->id);
      }

      return redirect('/')->with('flash_message', '投稿が完了しました');
    }

    public function report($id){
        $review = Review::findOrFail($id);
        $review->is_kaizened = true;
        $review->save();
        return redirect('/')->with('flash_message', 'レビューの改善報告が完了しました');
    }
}
