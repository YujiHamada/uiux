<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration {

  public function up() {
    Schema::create('follows', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->integer('follow_id')->unsigned(); // user_idがfollowするUsersテーブルのid
      $table->timestamps();

      // 制約
      $table->unique(['user_id', 'follow_id']);
      $table->foreign('user_id')->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
      $table->foreign('follow_id')->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
    });
  }

  public function down() {
    Schema::dropIfExists('follows');
  }
  
}
