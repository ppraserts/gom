<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOrderDateAdnDeliveryChanelToOrderStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('order_status_history', function (Blueprint $table) {
            $table->date('order_date');
            $table->string('delivery_chanel');
                        
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
            $table->dropColumn('order_date');
            $table->dropColumn('delivery_chanel');
        });
    }
}
