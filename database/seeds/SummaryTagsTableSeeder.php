<?php

use Illuminate\Database\Seeder;
use App\SummaryTag;

class SummaryTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      // summary_tabsテーブルの作成
      SummaryTag::summaryTags();
    }
}
