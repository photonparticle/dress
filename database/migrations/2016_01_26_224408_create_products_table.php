<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active');
            $table->integer('main_category');
            $table->integer('position');
            $table->integer('quantity');
            $table->float('original_price');
            $table->float('price');
            $table->float('discount_price');
            $table->timestamp('discount_start');
            $table->timestamp('discount_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
