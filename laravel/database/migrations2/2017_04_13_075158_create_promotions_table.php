<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromotionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promotions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('shop_id')->index('promotions_shop_id_foreign');
			$table->string('promotion_title');
			$table->string('promotion_description')->nullable();
			$table->string('image_file', 1000)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->boolean('is_active')->default(1);
			$table->integer('sequence')->default(999);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('promotions');
	}

}
