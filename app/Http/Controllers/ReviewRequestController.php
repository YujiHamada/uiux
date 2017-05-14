<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Review;
use App\Tag;
use App\ReviewEvaluation;

class ReviewRequestController extends Controller
{

    public function show($reviewId){
        $review = Review::findOrFail($reviewId);
        //賛成・反対を取得。存在しなくても存在しないということをview側で必要なので必ず渡す
        $evaluation = ReviewEvaluation::where('review_id', $reviewId)->where('user_id', Auth::user()->id)->first();

        return view('review.request.show', compact('review', 'evaluation'));
    }

    public function create($reviewId = null) {

      if(!empty($reviewId)){
          $review = Review::findOrFail($reviewId);
      }
    	$tagNames = DB::table('tags')->where('is_master', 1)->orderBy('name', 'asc')->pluck('name');
      //タグをjquery autocompleteで使えるよう"hoge", "hoge"の形にする
      $tagNames = '"' .implode('","',$tagNames->all()) . '"';

    	return view('review.request.create',compact('tagNames', 'review'));
    }

    public function store(\App\Http\Requests\StoreReviewRequest $request){

      $userId = Auth::user()->id;
  	  $description = $request->input('description');
      $title = $request->input('title');
      $url = $request->input('url');
      $file = $request->file('uiImage');


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

      $review = Review::create([
                    'user_id' => $userId,
                    'type' => null,
                    'title' => $title,
                    'description' => $description,
                    'url' => $url,
                    'image_name' => $fileName,
                    'domain' => $domain,
                    'is_request' => true
                  ]);

      // タグが設定されている場合は保存処理を行う。
      $reviewTagNames = $request->input('review_tag_names');
      if(!is_null($reviewTagNames)) {
        Tag::insertReviewTag($reviewTagNames, $review->id);
      }

      return redirect('/')->with('flash_message', 'レビュー依頼が完了しました');
    }
}
