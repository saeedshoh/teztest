<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id');
            $table->json('invoice_response')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('transaction_id')->nullable();
            $table->json('transaction_response')->nullable();
            $table->json('payment_response')->nullable();
            $table->boolean('status')->default(false);
            $table->string('credit_card')->nullable();
            $table->integer('type')->default(1);
            $table->bigInteger('shop_id');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('withdraw_transactions');
    }
}
