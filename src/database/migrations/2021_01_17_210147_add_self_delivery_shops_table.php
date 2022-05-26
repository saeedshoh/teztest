<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSelfDeliveryShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->integer('delivery_price')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_shop_delivery')->default(true);
            $table->integer('delivery_price')->nullable();
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
            $table->dropColumn('delivery_price');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_shop_delivery');
            $table->dropColumn('delivery_price');
        });
    }
}
