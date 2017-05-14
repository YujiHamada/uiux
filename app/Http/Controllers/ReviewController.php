<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReviewComment;
use App\CommentEvaluation;

class ReviewController extends Controller
{
    public function storeComment(\App\Http\Requests\StoreReviewComment $request) {

      $reviewId = $request->input('reviewId');
      $comment = $request->input('comment');
      $userId = $request->input('userId');

      ReviewComment::create([
              'review_id' => $reviewId,
              'user_id' => $userId,
              'comment' => $comment
            ]);

    	return redirect('/review/' . $reviewId)->with('flash_message', '投稿が完了しました');
    }

    public function destroyComment(Request $request) {
    	$reviewComment = ReviewComment::where('id', $request->input('commentId'))->delete();
    	return redirect('/review/' . $request->input('reviewId'))->with('flash_message', 'コメントの削除が完了しました');
    }

    public function evaluateComment(Request $request) {
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
