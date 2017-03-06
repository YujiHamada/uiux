<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review_Comment;

class ReviewCommentController extends Controller
{
    public function store(\App\Http\Requests\StoreReviewComment $request){
    	$reviewComment = new Review_Comment;
    	$reviewId = $request->input('reviewId');

    	$reviewComment->comment = $request->input('comment');
    	$reviewComment->user_id = $userId = $request->input('userId');
    	$reviewComment->review_id = $reviewId;

    	$reviewComment->save();

    	return redirect('/review/' . $reviewId)->with('flash_message', '投稿が完了しました');
    }

    public function destroy(Request $request){
    	$reviewComment = Review_Comment::where('id', $request->input('commentId'))->first()->delete();
    	return redirect('/review/' . $request->input('reviewId'))->with('flash_message', 'コメントの削除が完了しました');
    }
}
