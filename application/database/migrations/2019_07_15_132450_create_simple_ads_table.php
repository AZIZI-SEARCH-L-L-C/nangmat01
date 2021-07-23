<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimpleAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('title');
            $table->string('description');
            $table->string('keywords');
            $table->string('url');
            $table->string('Vurl');
            $table->boolean('turn');
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
        Schema::drop('simple_ads');
    }
}
