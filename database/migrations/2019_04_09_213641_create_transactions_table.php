<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_code');
            $table->string('serial_code');
            $table->string('name');
            $table->string('img_path');
            $table->string('rent_date');
            $table->string('return_date');
            $table->integer('duration');
            $table->integer('price');
            $table->string('status');
            $table->unsignedBigInteger('items_id');
            $table->foreign('items_id')->references('id')->on('items');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
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
        Schema::dropIfExists('transactions');
    }
}
