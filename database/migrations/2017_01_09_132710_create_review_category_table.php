<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_category', function (Blueprint $table) {

            $table->integer('review_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();

            // 制約
            $table->primary(['review_id', 'category_id']);
            $table->foreign('review_id')->references('id')->on('reviews')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
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
        Schema::drop('review_category');
    }
}
