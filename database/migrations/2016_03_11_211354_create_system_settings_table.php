<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table)
        {
            $table->increments('id');
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
        Schema::drop('system_settings');
    }
}
