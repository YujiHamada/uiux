<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Review;

class ReviewRequestController extends Controller
{

    public function show($reviewId){
        $review = Review::findOrFail($reviewId);
        //賛成・反対を取得。存在しなくても存在しないということをview側で必要なので必ず渡す
        // $agree = Review_Agree::where('review_id', $reviewId)->where('user_id', Auth::user()->id)->first();

        return view('review.request.show', compact('review'));
    }

    public function create() {
    	$tagNames = DB::table('tags')->where('is_master', 1)->orderBy('name', 'asc')->pluck('name');
        $tagNames = '"' .implode('","',$tagNames->all()) . '"';
    	return view('review.request.create',compact('tagNames'));
    }

    public function confirm(Request $request){
    	$description = $request->input('description');
        $title = $request->input('title');
        $file = $request->file('uiImage');
        $url = $request->input('url');
        $selectedTags = $request->input('tags');

        if($file){
            $fileName = md5($file->getClientOriginalName()) . '.' .$file->getClientOriginalExtension();
            $file->move(\Config::get('const.TEMPORARY_IMAGE_FILE_DIRECTORY'), $fileName);
        }
        return view('review.request.confirm', compact('title', 'description', 'fileName', 'url', 'selectedTags'));
    }

    public function store(Request $request){
    	$description = $request->input('description');
        $title = $request->input('title');
        $fileName = $request->input('fileName');
        $url = $request->input('url');

        $parseUrl = parse_url($url);
        $domain = "";
        if(isset($parseUrl['host'])){
            $domain = $parseUrl['host'];
        }

        $user_id = Auth::user()->id;

        $reviewRequest = new Review;
        $reviewRequest->title = $title;
        $reviewRequest->description = $description;
        $reviewRequest->image_name = $fileName;
        $reviewRequest->url = $url;
        $reviewRequest->domain = $domain;
        $reviewRequest->user_id = $user_id;
        $reviewRequest->is_request = true;

        $reviewRequest->save();

        return redirect('/')->with('flash_message', 'レビュー依頼が完了しました');
    }
}
