<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousels', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->json('products');
            $table->integer('max_products');
            $table->timestamp('active_from');
            $table->timestamp('active_to');
            $table->integer('position');
            $table->string('type');
            $table->string('target');
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
        Schema::drop('carousels');
    }
}
