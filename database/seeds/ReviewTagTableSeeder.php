<?php

use Illuminate\Database\Seeder;

class ReviewTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	$reviews = DB::table('reviews')->get();
		$tags = DB::table('tags')->get();
		$tagsCount = DB::table('tags')->count();

		for($i = 0; $i < count($reviews); $i++) {
		// ランダムにタグを選ぶ準備
		$randomCateIndex = rand(0, $tagsCount - 1);

		DB::table('review_tag')->insert([
		  'review_id' => $reviews[$i]->id,
		  'tag_id' => $tags[$randomCateIndex]->id
		]);
		}
    }
}
