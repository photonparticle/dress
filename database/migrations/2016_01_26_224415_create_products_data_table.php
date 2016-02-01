<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('object');
            $table->string('type');
            $table->integer('number');
            $table->tinyInteger('bool');
            $table->string('string');
            $table->longText('text');
            $table->timestamp('dateTime');
            $table->json('json');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_data');
    }
}
