<?php

use Illuminate\Database\Seeder;
use App\Review;
use Carbon\Carbon;


class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // テストデータの準備

      $urlYYUIUX = 'http://uiux.com/';
      $domainYYUIUX = 'uiux.com';
      $goodOrBads = array(1, 0, 2, 1);
      $titles = array('github', 'android', 'mac', 'laravel');
      $imageNames = array(
        'myimages/github.png',
        'myimages/android.jpg',
        'myimages/apple.png',
        'myimages/laravel.png'
      );

      // テストデータの作成

      // For hamada
      $hamada = DB::table('users')->where('email', 'oc.yuji@gmail.com')->first();
      for($i = 0; $i < count($titles); $i++) {
        $date = Carbon::now()->subDay(mt_rand(0, 28))->subMonth(mt_rand(0, 11))->format('Y-m-d H:i:s');
        DB::table('reviews')->insert([
          'user_id' => $hamada->id,
          'good_or_bad' => $goodOrBads[$i],
          'title' => $hamada->name . '\'s ' . $titles[$i],
          'description' => $titles[$i] . ' description.',
          'url' => $urlYYUIUX,
          'domain' => $domainYYUIUX,
          'image_name' => $imageNames[$i],
          'is_request' => false,
          'created_at' => $date,
          'updated_at' => $date
        ]);
      }
      // For yutamaro0405
      $yutamaro0405 = DB::table('users')->where('email', 'yutamaro0405@gmail.com')->first();
      for($i = 0; $i < count($titles); $i++) {
        $date = Carbon::now()->subDay(mt_rand(0, 28))->subMonth(mt_rand(0, 11))->format('Y-m-d H:i:s');
        DB::table('reviews')->insert([
          'user_id' => $yutamaro0405->id,
          'good_or_bad' => $goodOrBads[$i],
          'title' => $yutamaro0405->name . '\'s ' . $titles[$i],
          'description' => $titles[$i] . ' description. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.',
          'url' => $urlYYUIUX,
          'domain' => $domainYYUIUX,
          'image_name' => $imageNames[$i],
          'is_request' => false,
          'created_at' => $date,
          'updated_at' => $date
        ]);
      }

      // For yoshimi
      $yoshimi = DB::table('users')->where('email', 'yoshimi@gmail.com')->first();
      for($i = 0; $i < count($titles); $i++) {
        $date = Carbon::now()->subDay(mt_rand(0, 28))->subMonth(mt_rand(0, 11))->format('Y-m-d H:i:s');
        DB::table('reviews')->insert([
          'user_id' => $yoshimi->id,
          'good_or_bad' => $goodOrBads[$i],
          'title' => $yoshimi->name . '\'s ' . $titles[$i],
          'description' => $titles[$i] . ' description. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.',
          'url' => $urlYYUIUX,
          'domain' => $domainYYUIUX,
          'image_name' => $imageNames[$i],
          'is_request' => false,
          'created_at' => $date,
          'updated_at' => $date
        ]);
      }
      // For rika
      $rika = DB::table('users')->where('email', 'rika@gmail.com')->first();
      for($i = 0; $i < count($titles); $i++) {
        $date = Carbon::now()->subDay(mt_rand(0, 28))->subMonth(mt_rand(0, 11))->format('Y-m-d H:i:s');
        DB::table('reviews')->insert([
          'user_id' => $rika->id,
          'good_or_bad' => $goodOrBads[$i],
          'title' => $rika->name . '\'s ' . $titles[$i],
          'description' => $titles[$i] . ' description. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.',
          'url' => $urlYYUIUX,
          'domain' => $domainYYUIUX,
          'image_name' => $imageNames[$i],
          'is_request' => false,
          'created_at' => $date,
          'updated_at' => $date
        ]);
      }
    }
}
