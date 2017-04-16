<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      DB::table('tags')->insert([
        'name' => 'ui',
        'is_master' => '1'
      ]);
      DB::table('tags')->insert([
        'name' => 'ux',
        'is_master' => '1'
      ]);
      DB::table('tags')->insert([
        'name' => 'yyuiux',
        'is_master' => '1'
      ]);
    }
}
