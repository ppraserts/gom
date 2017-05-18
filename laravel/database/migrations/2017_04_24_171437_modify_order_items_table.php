<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use app\Helpers\MigrationHelper;

class ModifyOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // Schema::disableForeignKeyConstraints();

        Schema::table('order_items', function (Blueprint $table) {

            $foreignKeys = MigrationHelper::listTableForeignKeys('order_items');

            if(in_array('fk_order_items_product_requests_id', $foreignKeys)) {
                $table->dropForeign('fk_order_items_product_requests_id');
            }

            if (Schema::hasColumn('order_items' , 'product_request_id')) {
                $table->renameColumn('product_request_id' , 'product_id');
            }

        });

        Schema::table('order_items', function (Blueprint $table) {

            $foreignKeys = MigrationHelper::listTableForeignKeys('order_items');
            if(!in_array('fk_order_items_products_id', $foreignKeys)) {
                $table->foreign('product_id' , 'fk_order_items_products_id' )->references('id')->on('products');
            }

        });

       // Schema::enableForeignKeyConstraints();
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
            $table->dropForeign('fk_order_items_products_id');
        });
    }

}
