<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            
        	$table->string('name');
            $table->string('slug');
        	$table->boolean('active')->default(true);
        	$table->string('logo');
        	$table->string('url');
        	$table->string('facebook');
        	$table->string('twitter');
        	$table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sponsors');
    }
}
