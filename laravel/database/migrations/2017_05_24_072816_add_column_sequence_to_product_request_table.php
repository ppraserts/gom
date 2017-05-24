<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\ProductRequest;

class AddColumnSequenceToProductRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->integer('sequence');
        });

        ProductRequest::where('iwantto','=','sale')
            ->update(['sequence' => '999']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
    }
}
