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
      // 外部キー制約の関係上、テーブル削除処理を外だしして、
      // 先に該当テーブルを削除。
      // テーブルの消す順序に注意。
      $this->call(DeleteTableSeeder::class);

      // 初期データ作成
      // (テストデータ含む)
      $this->call(UsersTableSeeder::class);
      $this->call(TagsTableSeeder::class);
      $this->call(ReviewsTableSeeder::class);
      $this->call(ReviewTagTableSeeder::class);
      $this->call(FollowsTableSeeder::class);

    }
}
