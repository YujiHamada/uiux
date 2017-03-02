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
         $categories = DB::table('categories')->get();
         View::share('categories', $categories);
       } catch (\Exception $e) {
         // 「categories」テーブルがない場合エラーが出るのでcatch。
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
