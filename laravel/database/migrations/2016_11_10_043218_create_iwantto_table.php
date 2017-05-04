<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIwanttoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Iwantto', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('iwantto', ['buy', 'sale'])->default("buy");
            $table->string('product_title')->default("");
            $table->text('product_description');
            $table->string('guarantee')->default("");
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_showprice')->default(false);
            $table->decimal('volumn', 10, 2)->default(0);

            $table->string('product1_file')->default("");
            $table->string('product2_file')->default("");
            $table->string('product3_file')->default("");
            $table->enum('productstatus', ['open', 'soldout', 'close'])
                  ->default("open");

            $table->decimal('pricerange_start', 10, 2)->default(0);
            $table->decimal('pricerange_end', 10, 2)->default(0);
            $table->decimal('volumnrange_start', 10, 2)->default(0);
            $table->decimal('volumnrange_end', 10, 2)->default(0);

            $table->string('units')->default("");
            $table->string('city')->default("");
            $table->string('province')->default("");
            $table->integer('productcategorys_id')->unsigned()->nullable();
            $table->integer('products_id')->unsigned()->nullable();
            $table->integer('users_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('Iwantto', function($table) {
            $table->foreign('productcategorys_id')->references('id')->on('productcategorys');
            $table->foreign('products_id')->references('id')->on('products');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("Iwantto");
    }
}
