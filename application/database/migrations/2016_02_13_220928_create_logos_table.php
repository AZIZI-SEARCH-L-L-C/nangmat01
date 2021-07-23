<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logos', function (Blueprint $table) {
            $table->increments('id');
			$table->string('engine_name');
			$table->foreign('engine_name')->references('name')->on('engines');
            $table->string('content');
            $table->integer('order');
            $table->boolean('type');
            $table->boolean('active');
            $table->timestamp('starts');
            $table->timestamp('ends');
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
        Schema::drop('logos');
    }
}
