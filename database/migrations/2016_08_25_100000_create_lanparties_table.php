<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanpartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lanparties', function (Blueprint $table) {
            $table->increments('id');
        	$table->timestamps();
        	$table->softDeletes();
        	
        	$table->string('title');
        	$table->string('subtitle');
        	$table->text('description');
        	$table->dateTime('start');
        	$table->dateTime('end');
        	$table->dateTime('registrationstart');
        	$table->dateTime('registrationend');
        	$table->unsignedInteger('markeddays')->default(14);
        	$table->boolean('releaseseataftermarkeddays')->default(false);
        	$table->float('costs')->default(25);
        	$table->unsignedInteger('coins')->default(25);
        	$table->string('accountholder')->default('Roland Bücker');
        	$table->string('accountnumber')->default('1019823184');
        	$table->string('banknumber')->default('120 300 00');
        	$table->string('iban')->default('DE07 120 300 00 1019823184');
        	$table->string('bic')->default('BYLADEM1001');
        	$table->string('reasonforpayment');
        	$table->boolean('reserveregularseats')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lanparties');
    }
}
