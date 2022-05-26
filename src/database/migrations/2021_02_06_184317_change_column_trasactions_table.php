<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTrasactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('transaction_id')->nullable()->change();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->json('invoice_response')->nullable();
            $table->string('desc')->nullable();
            $table->renameColumn('response', 'transaction_response');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
