<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
