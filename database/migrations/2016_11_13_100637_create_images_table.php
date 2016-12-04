<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('album_id');
            $table->foreign('album_id')->references('id')->on('albums');

            $table->text('caption');
            $table->text('filename');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
