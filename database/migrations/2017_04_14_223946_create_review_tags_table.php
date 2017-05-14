<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTagsTable extends Migration {

  public function up() {
    Schema::create('review_tags', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('review_id')->unsigned();
      $table->integer('tag_id')->unsigned();
      $table->timestamps();

      // 制約
      $table->unique(['review_id', 'tag_id']);
      $table->foreign('review_id')->references('id')->on('reviews')
              ->onDelete('cascade')->onUpdate('cascade');
      $table->foreign('tag_id')->references('id')->on('tags')
              ->onDelete('cascade')->onUpdate('cascade');
    });
  }

  public function down() {
    Schema::drop('review_tags');
  }

}
