<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDeliveryAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_agencies', function (Blueprint $table) {
            $table->string("phone_number")->nullable();
            $table->string("logo")->nullable()->change();
            $table->string("status")->default("ACTIVE");
            $table->decimal("delivery_price")->default(0);
            $table->bigInteger("user_id");
            $table->bigInteger("city_id");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_agencies', function (Blueprint $table) {
            $table->dropColumn("phone_number");
            $table->dropColumn("status");
            $table->dropColumn("delivery_price");
            $table->bigInteger("user_id");
            $table->bigInteger("city_id");
            $table->bigInteger("deleted_at");
        });
    }
}
