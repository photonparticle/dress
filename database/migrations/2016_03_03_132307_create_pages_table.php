<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->longText('content');
			$table->string('page_title');
			$table->string('meta_description');
			$table->string('meta_keywords');
			$table->tinyInteger('active');
			$table->tinyInteger('show_footer');
			$table->tinyInteger('show_navigation');
			$table->integer('footer_position');
			$table->integer('navigation_position');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages');
	}
}
