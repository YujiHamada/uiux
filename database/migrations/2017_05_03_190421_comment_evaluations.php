<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommentEvaluations extends Migration {

  public function up() {
    Schema::create('comment_evaluations', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('comment_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->integer('is_agree')->unsigned();
      $table->timestamps();

      // 制約
      $table->unique(['comment_id', 'user_id']);
      $table->foreign('comment_id')->references('id')->on('review_comments')
              ->onDelete('cascade')->onUpdate('cascade');
      $table->foreign('user_id')->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
    });
  }

  public function down() {
    Schema::dropIfExists('comment_evaluations');
  }

}
