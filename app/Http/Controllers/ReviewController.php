<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ReviewComment;
use App\CommentEvaluation;
use App\Review;
use App\ReviewEvaluation;

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

    // postかrequestかにより、戻る画面を振り分ける
    if(Review::find($reviewId)->is_request) {
      return redirect('/request/' . $reviewId)->with('flash_message', '投稿が完了しました');
    } else {
      return redirect('/post/' . $reviewId)->with('flash_message', '投稿が完了しました');
    }
  }

  public function deleteComment(Request $request) {

    $reviewId = $request->input('reviewId');
    $commentId = $request->input('commentId');

  	$reviewComment = ReviewComment::where('id', $commentId)->delete();

    // postかrequestかにより、戻る画面を振り分ける
    if(Review::find($reviewId)->is_request) {
      return redirect('/request/' . $reviewId)->with('flash_message', 'コメントの削除が完了しました');
    } else {
      return redirect('/post/' . $reviewId)->with('flash_message', 'コメントの削除が完了しました');
    }
  }

  public function evaluateReview(Request $request) {

    $reviewEvaluation = ReviewEvaluation::where('review_id', $request->review_id)->where('user_id', Auth::user()->id)->first();

    if(!empty($reviewEvaluation)){
      //すでにレビューに対する評価があったらその評価を削除して削除フラグを返却する
      ReviewEvaluation::destroy($reviewEvaluation->id);
      return response()->json([
          'isDeleted' => true
      ]);
    }else{
      // まだ未評価の場合、評価を保存する。
      $evaluation = $request->evaluation;  // AGREE:'1' or DISAGREEE:'0'

      $reviewEvaluation = new ReviewEvaluation;
      $reviewEvaluation->user_id = $request->user_id;
      $reviewEvaluation->review_id = $request->review_id;
      $reviewEvaluation->is_agree = $evaluation;

      $reviewEvaluation->save();

      return response()->json([
          'evaluation' => $evaluation
      ]);
    }
  }

  public function evaluateComment(Request $request) {
    $commentEvaluation = CommentEvaluation::where('comment_id', $request->comment_id)->where('user_id', $request->user_id)->first();

    if(!empty($commentEvaluation)){
      //すでにレビューに対する評価があったらその評価を削除して削除フラグを返却する
      CommentEvaluation::destroy($commentEvaluation->id);
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

  public function delete($reviewId){
    Review::destroy($reviewId);
    return redirect('/')->with('flash_message', '削除が完了しました');
  }
}
