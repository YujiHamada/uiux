<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_evaluations', function (Blueprint $table) {

            $table->integer('review_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('is_agree')->unsigned();
            $table->timestamps();

            // 制約
            $table->primary(['review_id', 'user_id']);
            $table->foreign('review_id')->references('id')->on('reviews')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('review_evaluations');
    }
}
