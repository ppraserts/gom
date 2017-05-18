<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifiesProductRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropForeign('iwantto_productcategorys_id_foreign');

            $table->integer('unit_id')->after('users_id')->unsigned()->nullable();
            $table->integer('market_id')->after('unit_id')->unsigned()->nullable();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('market_id')->references('id')->on('markets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            //
        });
    }
}
