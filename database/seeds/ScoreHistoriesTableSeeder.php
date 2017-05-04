<?php

use Illuminate\Database\Seeder;
use App\Review;

class ScoreHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      $reviews = Review::all();
      foreach($reviews as $review) {

        $scoreHistoryKey = 'r' . $review->id . 'u' .$review->user_id;

        DB::table('score_histories')->insert([
          'key' => $scoreHistoryKey,
          'user_id' => $review->user_id,
          'score' => 5
        ]);
      }
    }
}
