<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders_items', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('order_id')->nullable()->index('order_id');
			$table->integer('product_id')->nullable();
			$table->decimal('unit_price', 10, 0)->nullable();
			$table->decimal('quantity', 10, 0)->nullable();
			$table->decimal('discount', 10, 0)->nullable();
			$table->decimal('total', 10, 0)->nullable();
			$table->boolean('order_item_status')->nullable();
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
		Schema::drop('orders_items');
	}

}
