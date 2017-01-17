<?php

use Illuminate\Database\Seeder;

class ReviewCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $reviews = DB::table('reviews')->get();
      $categories = DB::table('categories')->get();
      $categoriesCount = DB::table('categories')->count();

      for($i = 0; $i < count($reviews); $i++) {
        // ランダムにカテゴリを選ぶ準備
        $randomCateIndex = rand(0, $categoriesCount - 1);

        DB::table('review_category')->insert([
          'review_id' => $reviews[$i]->id,
          'category_id' => $categories[$randomCateIndex]->id
        ]);
      }
    }
}
