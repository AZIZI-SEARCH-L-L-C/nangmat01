<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_targets', function (Blueprint $table) {
            $table->increments('id');
			
			// related to cost
			$table->string('show_in', 50); // engines types sperated by "," or 0:any 
			$table->string('continent', 50); // or 0:any
			$table->string('inc_countries', 500); // 2 characters iso code - sperated by ","
			$table->string('exc_countries', 500); // sperated by ","
			$table->string('Interests', 1000); // or 0:any
			$table->boolean('gender'); // 0:any, 1:male, 2:female 
			$table->string('age', 7); // from,to e.g: 24,50 or 0:any
			$table->string('language', 500); // languages codes or 0:any
			
			// date time
			$table->timestamp('start')->nullable(); // how much $ run this
			$table->timestamp('end')->nullable(); // how much $ run this
			
            $table->integer('ad_id')->unsigned();
			$table->foreign('ad_id')->references('id')->on('ads');
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
        Schema::drop('ads');
    }
}
