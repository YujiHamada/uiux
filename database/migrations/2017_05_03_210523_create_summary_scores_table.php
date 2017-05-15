<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryScoresTable extends Migration {
  
  public function up() {
    Schema::create('summary_scores', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->string('user_name'); // テーブルのjoin数を減らすため、カラムを持つこととする。
      $table->string('avatar_image_path')->nullable(); // テーブルのjoin数を減らすため、カラムを持つこととする。
      $table->integer('score')->unsigned();
      $table->timestamps();

      // 制約
      $table->foreign('user_id')->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
    });
  }

  public function down() {
    Schema::dropIfExists('summary_scores');
  }

}
