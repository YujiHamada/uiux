<?php

use Illuminate\Database\Seeder;
use App\SummaryScore;

class SummaryScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      // summary_scoresテーブルの作成
      SummaryScore::summaryScores();

      // userテーブルのscoreカラムを更新
      SummaryScore::updateAllUserScore();
    }
}
