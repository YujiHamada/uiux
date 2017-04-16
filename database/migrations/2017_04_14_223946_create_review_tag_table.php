<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('review_tag', function (Blueprint $table) {

            $table->integer('review_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->timestamps();

            // 制約
            $table->primary(['review_id', 'tag_id']);
            $table->foreign('review_id')->references('id')->on('reviews')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                    ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('review_tag');
    }
}
