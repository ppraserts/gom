<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use app\Helpers\MigrationHelper;

class ChangeColumnProductIdToProductRequestIdInOrderItmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('order_items', function (Blueprint $table) {

            $foreignKeys = MigrationHelper::listTableForeignKeys('order_items');

            if(in_array('fk_order_items_products_id', $foreignKeys)) {
                $table->dropForeign('fk_order_items_products_id');
            }

            if (Schema::hasColumn('order_items' , 'product_id')) {
                $table->renameColumn('product_id' , 'product_request_id');
            }

        });

        Schema::table('order_items', function (Blueprint $table) {

            $foreignKeys = MigrationHelper::listTableForeignKeys('order_items');
            if(!in_array('fk_order_items_products_requests_id', $foreignKeys)) {
                $table->foreign('product_request_id' , 'fk_order_items_products_requests_id' )->references('id')->on('product_requests');
            }

        });
        Schema::enableForeignKeyConstraints();
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
            $table->dropForeign('fk_order_items_products_requests_id');
        });
    }
}
