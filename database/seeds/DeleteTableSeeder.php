<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Review;
use App\Tag;
use App\Follow;
use App\Review_Tag;

class DeleteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('review_tag')->delete();
      DB::table('reviews')->delete();
      DB::table('tags')->delete();
      DB::table('follows')->delete();
      DB::table('users')->delete();
    }
}
