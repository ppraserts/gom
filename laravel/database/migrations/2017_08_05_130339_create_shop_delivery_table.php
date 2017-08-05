<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->nullable(false);
            $table->integer('delivery_name')->nullable(false);
            $table->integer('delivery_price')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("shop_delivery");
    }
}
