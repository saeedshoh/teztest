<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_media', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('title')->nullable();
            $table->integer('shop_id');
            $table->string('media_type')->nullable();
            $table->boolean('is_default')->default(0);
            $table->float('position')->default(0);
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
        Schema::dropIfExists('shop_media');
    }
}
