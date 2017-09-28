php artisan migrate:rollback<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shops', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->string('shop_title')->nullable();
			$table->string('shop_subtitle')->nullable();
			$table->text('shop_description', 65535)->nullable();
			$table->string('image_file_1', 1000)->nullable();
			$table->string('image_file_2', 1000)->nullable();
			$table->string('image_file_3')->nullable();
			$table->string('theme', 20)->nullable();
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
		Schema::drop('shops');
	}

}
