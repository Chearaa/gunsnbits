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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->boolean('active')->default(true);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street');
            $table->string('postcode');
            $table->string('city');
            $table->string('country');
            $table->double('geo_lat');
            $table->double('geo_long');
            $table->string('phone');
            $table->date('birthday');
            $table->string('avatar');

            $table->integer('maxseats')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
