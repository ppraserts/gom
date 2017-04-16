<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewForeignKeysToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Drop
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'product_id'))
            {
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('order_items', 'iwantto_id'))
            {
                $table->dropColumn('iwantto_id');
            }
        });

        //Add
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('id')->unsigned()->change();
            $table->integer('product_request_id')->unsigned()->nullable(false)->after('order_id');
        });

        //Foreign key
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_request_id', 'fk_order_items_product_requests_id')->references('id')->on('product_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
}
