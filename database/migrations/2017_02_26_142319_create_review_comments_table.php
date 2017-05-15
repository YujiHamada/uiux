<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewCommentsTable extends Migration {

  public function up() {
    Schema::create('review_comments', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('review_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->string('comment');
      $table->timestamps();

      // 制約
      $table->foreign('review_id')->references('id')->on('reviews')
              ->onDelete('cascade')->onUpdate('cascade');
      $table->foreign('user_id')->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');
    });
  }

  public function down() {
    Schema::dropIfExists('review_comments');
  }

}
