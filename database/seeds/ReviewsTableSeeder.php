<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Test data
      $urlYYUIUX = 'http://uiux.com/';
      $domainYYUIUX = 'uiux.com';


      DB::table('reviews')->delete();

      // For hamada

      // For yutamaro0405
      $yutamaro0405 = DB::table('users')->where('mail', 'yutamaro0405')->first();
      DB::table('reviews')->insert([
        'user_id' => $yutamaro0405->id,
        'good_or_bad' => 1,
        'title' => 'github',
        'description' => 'github description',
        'url' => $urlYYUIUX,
        'domain' => $domainYYUIUX
      ]);

    }
}
