<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ReviewComment;
use App\CommentEvaluation;
use App\Review;
use App\ReviewEvaluation;
use App\User;
use App\Notifications\HeaderNotification;

class ReviewController extends Controller
{
  public function storeComment(\App\Http\Requests\StoreReviewComment $request) {

    $reviewId = $request->input('reviewId');
    $commentText = $request->input('comment');
    $userId = $request->input('userId');

    $comment = ReviewComment::create([
            'review_id' => $reviewId,
            'user_id' => $userId,
            'comment' => $commentText
          ]);

    $review = Review::find($reviewId);

    // 自分のレビューでなければ通知を出す
    if(Auth::id() != $review->user_id){
        $notification['url'] = '/post/' . $review->id;
        $notification['message'] = Auth::user()->name . "さんがレビュー「" . $review->title . "」にコメントをしました！";
        $notification['type'] = 'COMMENT_REVIEW';
        $notification['type_id'] = $comment->id;
        User::notifyByUserId($review->user_id, $notification);
    }

    // postかrequestかにより、戻る画面を振り分ける
    if($review->is_request) {
      return redirect('/request/' . $reviewId)->with('flash_message', '投稿が完了しました');
    } else {
      return redirect('/post/' . $reviewId)->with('flash_message', '投稿が完了しました');
    }
  }

  public function deleteComment(Request $request) {

    $reviewId = $request->input('reviewId');
    $commentId = $request->input('commentId');

  	$reviewComment = ReviewComment::where('id', $commentId)->first()->delete();

    // postかrequestかにより、戻る画面を振り分ける
    if(Review::find($reviewId)->is_request) {
      return redirect('/request/' . $reviewId)->with('flash_message', 'コメントの削除が完了しました');
    } else {
      return redirect('/post/' . $reviewId)->with('flash_message', 'コメントの削除が完了しました');
    }
  }

  public function evaluateReview(Request $request) {

    $reviewEvaluation = ReviewEvaluation::where('review_id', $request->review_id)->where('user_id', Auth::id())->first();
    $review = Review::find($request->review_id);

    if(!empty($reviewEvaluation)){
        //すでにレビューに対する評価があったらその評価を削除して削除フラグを返却する
        ReviewEvaluation::where('id', $reviewEvaluation->id)->first()->delete();

        HeaderNotification::delete($review->user_id, 'EVALUATE_REVIEW', $reviewEvaluation->id);

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

        // 通知
        $notification['url'] = '/post/' . $review->id;
        $notification['message'] = Auth::user()->name . "さんがレビュー「" . $review->title ."」に評価をしました！";
        $notification['type'] = 'EVALUATE_REVIEW';
        $notification['type_id'] = $reviewEvaluation->id;
        User::notifyByUserId($review->user_id, $notification);

        return response()->json([
          'evaluation' => $evaluation
        ]);
    }
  }

  public function evaluateComment(Request $request) {
    $commentEvaluation = CommentEvaluation::where('comment_id', $request->comment_id)->where('user_id', Auth::id())->first();

    if(!empty($commentEvaluation)){
        //すでにレビューに対する評価があったらその評価を削除して削除フラグを返却する
        CommentEvaluation::where('id', $commentEvaluation->id)->first()->delete();

        HeaderNotification::delete($commentEvaluation->user_id, 'EVALUATE_REVIEW_COMMENT', $commentEvaluation->id);

        return response()->json([
          'isDeleted' => true,
          'commentId' => $request->comment_id
        ]);
    }else{

        //まだ未評価の場合、評価を保存する。
        $evaluation = $request->evaluation;

        $commentEvaluation = new CommentEvaluation;
        $commentEvaluation->user_id = Auth::id();
        $commentEvaluation->comment_id = $request->comment_id;
        $commentEvaluation->is_agree = $evaluation;

        $commentEvaluation->save();

        // 通知
        $notification['url'] = '/post/' . $request->reviewId;
        $notification['message'] = "コメントが評価されました";
        $notification['type'] = 'EVALUATE_REVIEW_COMMENT';
        $notification['type_id'] = $commentEvaluation->id;
        User::notifyByUserId($request->user_id, $notification);


        return response()->json([
          'evaluation' => $evaluation,
          'commentId' => $request->comment_id
        ]);
    }
  }

  public function delete($reviewId){
    Review::where('id', $reviewId)->first()->delete();

    return redirect('/')->with('flash_message', '削除が完了しました');
  }
}
