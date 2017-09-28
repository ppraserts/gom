<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_items', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('order_id')->nullable()->index('order_id');
			$table->integer('iwantto_id')->nullable();
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
		Schema::drop('order_items');
	}

}
