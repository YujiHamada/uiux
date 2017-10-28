<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\ScoreHistory;
use App\Review;
use App\ReviewComment;
use App\ReviewEvaluation;
use App\CommentEvaluation;
use App\ReviewTag;
use App\Tag;
use Config;
use App\SummaryTag;
use App\SummaryScore;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try{
            // 以下、グローバル変数定義と同意
            $summaryTags = DB::table('summary_tags')->get();
            View::share('summaryTags', $summaryTags);
            $summaryScores = DB::table('summary_scores')->get();
            View::share('summaryScores', $summaryScores);

            // Reviewレコードが新規作成された場合
            Review::created(function ($review) {
                $scoreHistoryKey = 'review' . $review->id . 'user' .$review->user_id;
                ScoreHistory::create([
      						'key' => $scoreHistoryKey,
                            'review_id' => $review->id,
      						'user_id' => $review->user_id,
      						'score' => Config::get('const.SCORE_REVIEW'),
                            'score_type' => Config::get('enum.score_type.REVIEW')
                        ]);

                $this->updateSummaryAndUserScore($review->user_id);
            });
            // Reviewレコードが削除された場合
            Review::deleted(function ($review) {
                $scoreHistoryKey = 'review' . $review->id . 'user' .$review->user_id;
	            ScoreHistory::where('key', $scoreHistoryKey)->delete();

                $this->updateSummaryAndUserScore($review->user_id);
            });


            // ReviewCommentレコードが新規作成された場合
            ReviewComment::created(function ($reviewComment) {
                $scoreHistoryKey = 'comment' . $reviewComment->id . 'user' .$reviewComment->user_id;
  		        ScoreHistory::create([
      						'key' => $scoreHistoryKey,
      						'user_id' => $reviewComment->user_id,
      						'score' => Config::get('const.SCORE_COMMENT'),
                            'score_type' => Config::get('enum.score_type.COMMENT')
                        ]);

                $this->updateSummaryAndUserScore($reviewComment->user_id);
            });
            // ReviewCommentレコードが削除された場合
            ReviewComment::deleted(function ($reviewComment) {
                $scoreHistoryKey = 'comment' . $reviewComment->id . 'user' .$reviewComment->user_id;
  		        ScoreHistory::where('key', $scoreHistoryKey)->delete();

                $this->updateSummaryAndUserScore($reviewComment->user_id);
            });


            // ReviewEvaluationレコードが新規作成された場合
            ReviewEvaluation::created(function ($reviewEvaluation) {
                $scoreHistoryKey = 'rEvaluation' . $reviewEvaluation->id . 'user' .$reviewEvaluation->user_id;
  		        ScoreHistory::create([
      						'key' => $scoreHistoryKey,
                            'review_id' => $reviewEvaluation->review_id,
      						'user_id' => $reviewEvaluation->user_id,
      						'score' => Config::get('const.SCORE_REVIEW_EVALUATION'),
                            'score_type' => Config::get('enum.score_type.REVIEW_EVALUATION')
                        ]);

                $this->updateSummaryAndUserScore($reviewEvaluation->user_id);
            });
            // ReviewEvaluationレコードが削除された場合
            ReviewEvaluation::deleted(function ($reviewEvaluation) {
                $scoreHistoryKey = 'rEvaluation' . $reviewEvaluation->id . 'user' .$reviewEvaluation->user_id;
  		        ScoreHistory::where('key', $scoreHistoryKey)->delete();

                $this->updateSummaryAndUserScore($reviewEvaluation->user_id);
            });

            // CommentEvaluationレコードが新規作成された場合
            CommentEvaluation::created(function ($commentEvaluation) {
                $scoreHistoryKey = 'cEvaluation' . $commentEvaluation->id . 'user' .$commentEvaluation->user_id;
  		        ScoreHistory::create([
      						'key' => $scoreHistoryKey,
                            'review_id' => $commentEvaluation->review_id,
      						'user_id' => $commentEvaluation->user_id,
      						'score' => Config::get('const.SCORE_COMMENT_EVALUATION'),
                            'score_type' => Config::get('enum.score_type.COMMENT_EVALUATION')
                        ]);

                $this->updateSummaryAndUserScore($commentEvaluation->user_id);
            });
            // CommentEvaluationレコードが削除された場合
            CommentEvaluation::deleted(function ($commentEvaluation) {
                $scoreHistoryKey = 'cEvaluation' . $commentEvaluation->id . 'user' .$commentEvaluation->user_id;
  		        ScoreHistory::where('key', $scoreHistoryKey)->delete();

                $this->updateSummaryAndUserScore($commentEvaluation->user_id);
            });


            // ReviewTagレコードが新規作成された場合
            ReviewTag::created(function ($reviewTag) {
                // summary_tabsテーブルの作成
                SummaryTag::summaryTags();
            });

            // ReviewTagレコードが削除された場合
            ReviewTag::deleted(function ($reviewTag) {
                // summary_tabsテーブルの作成
                SummaryTag::summaryTags();
            });

        } catch (\Exception $e) {
            // テーブルがない場合エラーが出るのでcatch。
            // （php artisan migrate:refresh対策）
        }
    }

    // summary_scoresテーブルの再作成と、usersテーブルのscoreカラムを更新する。
    private function updateSummaryAndUserScore($userId) {
        // summary_scoresテーブルの作成
        SummaryScore::summaryScores();
        // 対象userテーブルのscoreカラムを更新
        SummaryScore::updateUserScore($userId);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
