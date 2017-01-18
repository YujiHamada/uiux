<?php

use Illuminate\Database\Seeder;
use App\Review;


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
        DB::table('reviews')->insert([
          'user_id' => $hamada->id,
          'good_or_bad' => $goodOrBads[$i],
          'title' => $hamada->name . '\'s ' . $titles[$i],
          'description' => $titles[$i] . ' description',
          'url' => $urlYYUIUX,
          'domain' => $domainYYUIUX,
          'image_name' => $imageNames[$i]
        ]);
      }
      // For yutamaro0405
      $yutamaro0405 = DB::table('users')->where('email', 'yutamaro0405@gmail.com')->first();
      for($i = 0; $i < count($titles); $i++) {
        DB::table('reviews')->insert([
          'user_id' => $yutamaro0405->id,
          'good_or_bad' => $goodOrBads[$i],
          'title' => $yutamaro0405->name . '\'s ' . $titles[$i],
          'description' => $titles[$i] . ' description',
          'url' => $urlYYUIUX,
          'domain' => $domainYYUIUX,
          'image_name' => $imageNames[$i]
        ]);
      }
    }
}
