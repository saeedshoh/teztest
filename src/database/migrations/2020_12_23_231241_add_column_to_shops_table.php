<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->integer('tin')->nullable();
            $table->integer('sin')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_type')->nullable();
            $table->string('company_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('bik')->nullable();
            $table->string('bank_account_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('tin');
            $table->dropColumn('sin');
            $table->dropColumn('company_name');
            $table->dropColumn('company_type');
            $table->dropColumn('company_account_number');
            $table->dropColumn('bank_name');
            $table->dropColumn('bik');
            $table->dropColumn('bank_account_number');
        });
    }
}
