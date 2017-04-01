<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categories')->insert([
        'name' => 'ui',
        'is_master' => '1' 
      ]);
      DB::table('categories')->insert([
        'name' => 'ux',
        'is_master' => '1'
      ]);
      DB::table('categories')->insert([
        'name' => 'yyuiux',
        'is_master' => '1'
      ]);
    }
}
