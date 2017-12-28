<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Review;
use App\ReviewImage;
use App\Tag;
use App\ReviewEvaluation;
use App\Libs\Scraping;

class ReviewRequestController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show($reviewId){
        $review = Review::findOrFail($reviewId);
        if(isset($review->reviewImages[0]->image_name)){
            $ogImage = $review->reviewImages[0]->image_name;
        }
        return view('review.request.show', compact('review', 'ogImage'));
    }

    public function create($reviewId = null) {
        if(!empty($reviewId)){
            $review = Review::findOrFail($reviewId);
        }
        $tagNames = DB::table('tags')->where('is_master', 1)->orderBy('name', 'asc')->pluck('name');
        //タグをjquery autocompleteで使えるよう"hoge", "hoge"の形にする
        $tagNames = '"' .implode('","',$tagNames->all()) . '"';

        $title = 'レビュー依頼投稿画面' . \Config::get('const.SITE_TITLE_TEMPLATE');

        return view('review.request.create',compact('tagNames', 'review', 'title'));
    }

    public function store(\App\Http\Requests\StoreReviewRequest $request){
        $userId = Auth::user()->id;
        $description = $request->input('description');
        $title = $request->input('title');

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
            $review->type = null;
            $review->title = $title;
            $review->description = $description;
            $review->url = $url;
            $review->domain = $domain;
            $review->is_request = true;
            $review->url_title = $og['title'];
            $review->url_description = $og['description'];
            $review->url_image = $og['fileName'];
            $review->save();
        } else {
            //新規作成の場合
            $review = Review::create([
                            'user_id' => $userId,
                            'type' => null,
                            'title' => $title,
                            'description' => $description,
                            'url' => $url,
                            'image_name' => null,
                            'domain' => $domain,
                            'is_request' => true,
                            'url_title' => $og['title'],
                            'url_description' => $og['description'],
                            'url_image' => $og['fileName'],
                        ]);
        }

        // 複数の写真投稿
        $reviewImages = $request->input('review_images');
        if(!empty($reviewImages)) {
            foreach($reviewImages as $reviewImage) {
                ReviewImage::where('review_id', $reviewId)->delete();
                ReviewImage::firstOrCreate(['review_id' => $review->id, 'image_name' => $reviewImage]);
            }
        }

        // タグが設定されている場合は保存処理を行う。
        $reviewTagNames = $request->input('review_tag_names');
        if(!is_null($reviewTagNames)) {
            Tag::insertReviewTag($reviewTagNames, $review->id);
        }

        return redirect('/')->with('flash_message', 'レビュー依頼が完了しました');
    }
}
