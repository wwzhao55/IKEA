<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('age');
            $table->integer('room');
            $table->string('item_num');
            $table->string('color');
            $table->string('size');
            $table->decimal('price',10,2);
            $table->string('main_img');
            $table->tinyInteger('status');
            $table->integer('collect_num');
            $table->integer('comment_num');
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
        Schema::drop('products');
    }
}
