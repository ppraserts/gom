<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOrdersItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders_items', function(Blueprint $table)
		{
			$table->foreign('order_id', 'fk_orders_items_order_id')->references('id')->on('orders')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders_items', function(Blueprint $table)
		{
			$table->dropForeign('fk_orders_items_order_id');
		});
	}

}
