<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrimeryKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_primery_keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keyword', 80);
            $table->integer('leverage');
			$table->boolean('field');
			$table->string('operation', 1);
			$table->string('advancedOperation', 100);
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
        Schema::drop('ads_primery_keywords');
    }
}
