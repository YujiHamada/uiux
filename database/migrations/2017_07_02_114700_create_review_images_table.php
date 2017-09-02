<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewImagesTable extends Migration
{
    public function up() {
        Schema::create('review_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('review_id')->unsigned();
            $table->string('image_name')->nullable();

            // 制約
            $table->foreign('review_id')->references('id')->on('reviews')
                    ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('review_images');

    }
}
