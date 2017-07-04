<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->integer('register_end_time');
            $table->json('main_images');
            $table->text('content1');
            $table->json('images1');
            $table->text('content2');
            $table->json('images2');
            $table->text('content3');
            $table->json('images3');
            $table->text('content4');
            $table->json('images4');
            $table->text('content5');
            $table->json('images5');
            $table->tinyInteger('status');
            $table->integer('collect_num');
            $table->integer('comment_num');
            $table->integer('register_num');
            $table->integer('created_at');
            $table->integer('updated_at');
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('activities');
    }
}
