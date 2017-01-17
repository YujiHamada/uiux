<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

  // Please enter "php artisan db:seed" on the bash

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->call(CategoriesTableSeeder::class);
      $this->call(ReviewsTableSeeder::class);
      $this->call(UsersTableSeeder::class);
    }
}
