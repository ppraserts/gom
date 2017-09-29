<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOrderStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_status_history', function (Blueprint $table) {
            $table->string('status_text');
            $table->text('note');
            $table->string('image_payment_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_status_history', function (Blueprint $table) {
            $table->dropColumn('status_text');
            $table->dropColumn('note');
            $table->dropColumn('image_payment_url');
        });
    }
}
