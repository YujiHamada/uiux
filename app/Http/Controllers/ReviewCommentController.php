<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReviewComment;
use App\CommentEvaluation;

class ReviewCommentController extends Controller
{
    public function store(\App\Http\Requests\StoreReviewComment $request) {
    	$reviewComment = new ReviewComment;
    	$reviewId = $request->input('reviewId');

    	$reviewComment->comment = $request->input('comment');
    	$reviewComment->user_id = $userId = $request->input('userId');
    	$reviewComment->review_id = $reviewId;

    	$reviewComment->save();

    	return redirect('/review/' . $reviewId)->with('flash_message', '投稿が完了しました');
    }

    public function destroy(Request $request) {
    	$reviewComment = ReviewComment::where('id', $request->input('commentId'))->first()->delete();
    	return redirect('/review/' . $request->input('reviewId'))->with('flash_message', 'コメントの削除が完了しました');
    }

    public function evaluate(Request $request) {
        $commentEvaluation = CommentEvaluation::where('comment_id', $request->comment_id)->where('user_id', $request->user_id)->first();

        if(!empty($commentEvaluation)){
            //すでにレビューに対する評価があったらその評価を削除して削除フラグを返却する
            CommentEvaluation::where('comment_id', $request->comment_id)->where('user_id', $request->user_id)->delete();
            return response()->json([
                'isDeleted' => true,
                'commentId' => $request->comment_id
            ]);
        }else{
            //まだ未評価の場合、評価を保存する。
            $evaluation = $request->evaluation;

            $commentEvaluation = new CommentEvaluation;
            $commentEvaluation->user_id = $request->user_id;
            $commentEvaluation->comment_id = $request->comment_id;
            $commentEvaluation->is_agree = $evaluation;

            $commentEvaluation->save();

            return response()->json([
                'evaluation' => $evaluation,
                'commentId' => $request->comment_id
            ]);
        }
    }
}
