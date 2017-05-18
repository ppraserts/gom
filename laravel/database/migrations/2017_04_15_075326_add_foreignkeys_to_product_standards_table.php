<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeysToProductStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_standards', function (Blueprint $table) {
            //
            $table->foreign('product_request_id')->references('id')->on('product_requests');
            $table->foreign('standard_id')->references('id')->on('standards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_standards', function (Blueprint $table) {
            //
        });
    }
}
