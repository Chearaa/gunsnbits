<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCateringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caterings', function (Blueprint $table) {
        	$table->increments('id');
        	$table->timestamps();
        	$table->softDeletes();
        	
        	$table->string('title');
        	$table->string('image');
        	$table->text('description');
        	$table->float('costs')->default(0.0);
            $table->integer('sorting')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('caterings');
    }
}
