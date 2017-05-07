<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\ScoreHistory;
use App\Review;
use App\ReviewTag;
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
          $scoreHistoryKey = 'r' . $review->id . 'u' .$review->user_id;
      		ScoreHistory::create([
      						'key' => $scoreHistoryKey,
      						'user_id' => $review->user_id,
      						'score' => Config::get('const.SCORE_REVIEW')
      		]);

          // summary_scoresテーブルの作成
          SummaryScore::summaryScores();
          // 対象userテーブルのscoreカラムを更新
          SummaryScore::updateUserScore($review->user_id);
        });

        // Reviewレコードが削除された場合
        Review::deleted(function ($review) {
          $scoreHistoryKey = 'r' . $review->id . 'u' .$review->user_id;
      		ScoreHistory::where('key', $scoreHistoryKey)->delete();

          // summary_scoresテーブルの作成
          SummaryScore::summaryScores();
          // 対象userテーブルのscoreカラムを更新
          SummaryScore::updateUserScore($review->user_id);

        });


        // Tagレコードが新規作成された場合
        ReviewTag::created(function ($reviewTag) {
          // summary_tabsテーブルの作成
          SummaryTag::summaryTags();
        });

        // Tagレコードが削除された場合
        ReviewTag::deleted(function ($reviewTag) {
          // summary_tabsテーブルの作成
          SummaryTag::summaryTags();
        });

       } catch (\Exception $e) {
         // 「tags」テーブルがない場合エラーが出るのでcatch。
         // （php artisan migrate:refresh対策）
       }
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
