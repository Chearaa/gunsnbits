<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbpostimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fbpostimages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('fbpost_id')->nullable()->default(NULL);
            $table->foreign('fbpost_id')->references('id')->on('fbposts');

            $table->string('type');
            $table->string('url');
            $table->string('title');
            $table->text('description');
            $table->string('src');
            $table->integer('height')->unsigned()->default(0);
            $table->integer('width')->unsigned()->default(0);
            $table->string('basename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fbpostimages');
    }
}
