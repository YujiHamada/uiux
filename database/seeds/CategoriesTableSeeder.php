<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categories')->delete();

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
