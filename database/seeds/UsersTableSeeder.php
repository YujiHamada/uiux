<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'name' => 'hamada',
        'email' => 'oc.yuji@gmail.com',
        'password' => bcrypt('hamada')
      ]);
      DB::table('users')->insert([
        'name' => 'yutamaro0405',
        'email' => 'yutamaro0405@gmail.com',
        'password' => bcrypt('yutamaro0405')
      ]);
    }
}
