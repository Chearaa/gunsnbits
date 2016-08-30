<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unsignedInteger('lanparty_id');
            $table->foreign('lanparty_id')->references('id')->on('lanparties');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
        	$table->unsignedInteger('seatnumber');
        	$table->integer('status')->default(0); //0: free, 1:marked, 2:reserved, 3:payed, -1:disabled
        	$table->dateTime('marked_at');
        	$table->dateTime('reserved_at');
        	$table->dateTime('payed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seats');
    }
}
