<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbcommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fbcomments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('fbpost_id')->nullable()->default(NULL);
            $table->foreign('fbpost_id')->references('id')->on('fbposts');

            $table->string('fb_id');
            $table->text('message');
            $table->string('from_name');
            $table->string('from_id');
            $table->dateTime('created_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fbcomments');
    }
}
