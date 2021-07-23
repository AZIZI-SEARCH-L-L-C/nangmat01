<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('bill_id')->nullable();
            $table->string('password', 60);
            $table->boolean('confirmed')->default(0);
            $table->string('img', 500)->nullable();
            $table->string('confirmation_key')->nullable();
            $table->boolean('admin')->default(0);
            $table->float('credit')->default(0);
			$table->string('facebookID')->nullable();
			$table->string('twitterID')->nullable();
			$table->string('googleID')->nullable();
            $table->text('references')->nullable();
			$table->rememberToken();
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
        Schema::drop('users');
    }
}
