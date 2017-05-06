<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Review;
use App\Tag;
use App\Follow;
use App\ReviewTag;

class DeleteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('review_tags')->delete();
      DB::table('reviews')->delete();
      DB::table('tags')->delete();
      DB::table('follows')->delete();
      DB::table('users')->delete();
    }
}
