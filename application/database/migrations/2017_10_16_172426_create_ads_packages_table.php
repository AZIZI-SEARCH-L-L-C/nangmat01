<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('ads_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price', 6, 2);
            $table->integer('value');
            $table->boolean('type');
            $table->boolean('byBudget');
            $table->string('img');
            $table->string('description', 500);
            $table->string('shown_in');
            $table->timestamps();
        }); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Schema::drop('ads_packages'); */
    }
}