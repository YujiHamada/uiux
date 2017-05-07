<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\ScoreHistory;
use App\Review;
use Config;



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
        //  $tags = DB::table('tags')->where('is_master', '1')->get();
        //  View::share('tags', $tags);

        $summaryTags = DB::table('summary_tags')->get();
        View::share('summaryTags', $summaryTags);

        $summaryScores = DB::table('summary_scores')->get();
        View::share('summaryScores', $summaryScores);


        Review::created(function ($review) {
          $scoreHistoryKey = 'r' . $review->id . 'u' .$review->user_id;
      		ScoreHistory::create([
      						'key' => $scoreHistoryKey,
      						'user_id' => $review->user_id,
      						'score' => 5
      		]);
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
