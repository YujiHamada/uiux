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
        'name' => 'ui'
      ]);
      DB::table('categories')->insert([
        'name' => 'ux'
      ]);
      DB::table('categories')->insert([
        'name' => 'yyuiux'
      ]);
    }
}
