<?php

use Illuminate\Database\Seeder;

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
