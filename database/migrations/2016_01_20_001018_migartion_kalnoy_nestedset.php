<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigartionKalnoyNestedset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_nested_set', function (Blueprint $table)
        {
            \Kalnoy\Nestedset\NestedSet::columns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories_nested_set', function (Blueprint $table)
        {
            \Kalnoy\Nestedset\NestedSet::dropColumns($table);
        });
    }
}
