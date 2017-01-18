<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Review;
use App\Category;
use App\Review_Category;

class DeleteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('review_category')->delete();
      DB::table('reviews')->delete();
      DB::table('categories')->delete();
      DB::table('users')->delete();
    }
}
