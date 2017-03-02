<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->enum('social', ['twitter', 'facebook', 'google'])->nullable();
            $table->string('social_uid')->nullable();
            $table->string('avatar_name')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // 制約
            $table->unique(['id', 'social']);
            $table->unique(['social', 'social_uid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
