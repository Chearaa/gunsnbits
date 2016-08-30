<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('paypal_id')->unique();
            $table->string('intent');
            $table->string('state');
            $table->string('cart');
            $table->string('payer_status');
            $table->string('payer_email');
            $table->string('payer_first_name');
            $table->string('payer_last_name');
            $table->string('payer_id');
            $table->string('transaction_amount_total');
            $table->string('transaction_amount_currency');
            $table->string('transaction_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypals');
    }
}
