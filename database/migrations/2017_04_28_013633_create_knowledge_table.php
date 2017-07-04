<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKnowledgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('knowledge', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('category_id');
            $table->string('main_img');
            $table->json('images');
            $table->text('content');
            $table->tinyInteger('status');
            $table->integer('collect_num');
            $table->integer('comment_num');
            $table->integer('like_num');
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
        Schema::drop('knowledge');
    }
}
