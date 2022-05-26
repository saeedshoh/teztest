<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
            $table->string('phone_number');
            $table->string('address');
            $table->integer('city_id');
            $table->string('status');
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
            $table->string('logo');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropColumn('city_id');
            $table->dropColumn('status');
        });
    }
}
