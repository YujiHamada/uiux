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
use App\ReviewImage;
use App\SummaryTag;
use App\ReviewEvaluation;
use App\Libs\Scraping;

class ReviewPostController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['show']]);
    }

    //表示用
    public function show($reviewId){
        $review = Review::findOrFail($reviewId);
        $title = 'yyUX | ' . $review->title;

        if(isset($review->reviewImages[0]->image_name)){
            $ogImage = $review->reviewImages[0]->image_name;
        }

        Review::updatePageView($reviewId);

        return view('review.post.show', compact('review', 'title', 'ogImage'));
    }

    //投稿用
    public function create($reviewId = null) {
        if(!empty($reviewId)){
            $review = Review::findOrFail($reviewId);
        }
        $tagNames = DB::table('tags')->where('is_master', 1)->orderBy('name', 'asc')->pluck('name');
        //タグをjquery autocompleteで使えるよう"hoge", "hoge"の形にする
        $tagNames = '"' .implode('","',$tagNames->all()) . '"';

        $title = 'レビュー投稿画面' . \Config::get('const.SITE_TITLE_TEMPLATE');

        return view('review.post.create',compact('tagNames', 'review', 'title'));
    }

    //投稿完了画面表示用
    public function store(\App\Http\Requests\StoreReviewPost $request){
        $userId = Auth::user()->id;
        $description = $request->input('description');
        $title = $request->input('title');
        $type = $request->input('type');

        $url = $request->input('url');
        if(!empty($url)){
            $parseUrl = parse_url($url);
            $domain = $parseUrl['host'];
        } else {
            $url = null;
            $domain = null;
        }
        $og = Scraping::ogp($url);

        $reviewId = $request->input('review_id');
        if($reviewId) {
            // 編集の場合
            $review = Review::findOrFail($reviewId);
            $review->user_id = $userId;
            $review->type = $type;
            $review->title = $title;
            $review->description = $description;
            $review->url = $url;
            $review->domain = $domain;
            $review->is_request = false;
            $review->url_title = $og['title'];
            $review->url_description = $og['description'];
            $review->url_image = $og['fileName'];
            $review->save();
        } else {
            //新規作成の場合
            $review = Review::create([
                            'user_id' => $userId,
                            'type' => $type,
                            'title' => $title,
                            'description' => $description,
                            'url' => $url,
                            'image_name' => null,
                            'domain' => $domain,
                            'is_request' => false,
                            'url_title' => $og['title'],
                            'url_description' => $og['description'],
                            'url_image' => $og['fileName'],
                        ]);
        }

        // 複数の写真投稿
        $reviewImages = $request->input('review_images');
        ReviewImage::where('review_id', $reviewId)->delete();
        if(!empty($reviewImages)) {
            foreach($reviewImages as $reviewImage) {
                ReviewImage::firstOrCreate(['review_id' => $review->id, 'image_name' => $reviewImage]);
            }
        }

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
