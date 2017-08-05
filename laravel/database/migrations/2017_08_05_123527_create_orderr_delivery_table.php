<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderrDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_buy_id');
            $table->integer('user_sale_id');
            $table->integer('order_id');
            $table->string('shipping_channel');
            $table->integer('delivery_charge');
            $table->integer('sum_delivery_charge');
            $table->integer('selected');
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
        Schema::drop("ProductCategorys");
    }
}
