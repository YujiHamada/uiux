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
      SummaryTag::summaryTags();
    }
}
