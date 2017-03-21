<?php

use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $users1 = DB::table('users')->get(); // user_id候補
      $users2 = DB::table('users')->get(); // follow_id候補

      foreach($users1 as $user1) {
        foreach($users2 as $user2) {
          if($user1->id !== $user2->id && rand(1 , 3) >= 2) {
            DB::table('follows')->insert([
              'user_id' => $user1->id,
              'follow_id' => $user2->id
            ]);
          }
        }
      }

    }
}
