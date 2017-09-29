<?php

use Illuminate\Database\Migrations\Migration;
use App\OrderStatus;

class InsertOrderStatusDataToOrderStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('order_status')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusNameArrs = array('สั่งซื้อ','ยืนยันการสั่งซื้อ','แจ้งชำระเงิน','จัดส่งแล้ว','ยกเลิกรายการสั่งซื้อ');
        $id = 1 ;
        foreach ($statusNameArrs as $statusNameArr) {
            $OrderStatus = new OrderStatus();
            $OrderStatus->id = $id;
            $OrderStatus->status_name = $statusNameArr;
            $OrderStatus->save();
            $id++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('order_status')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
