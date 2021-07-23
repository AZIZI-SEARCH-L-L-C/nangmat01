<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->string('title');
            $table->string('description');
            $table->string('slug')->unique();
            $table->string('keywords');
            $table->string('url');
            $table->string('Vurl');
            $table->integer('impressions');
            $table->integer('clicks');
            $table->boolean('turn');
            $table->boolean('approved');
			$table->boolean('type'); // 0: per clicks, 1: per impressions, 2: per days 
			$table->float('costPer', 8, 5); // cost per type depending on bollow factors
			$table->boolean('useBudget'); // use budget or not
			$table->float('budget', 10, 5); // starter budget
			$table->float('paid', 10, 5); // how much paid
			
            $table->integer('user_id')->unsigned();
            $table->integer('compain_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('compain_id')->references('id')->on('ads_compains');
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
