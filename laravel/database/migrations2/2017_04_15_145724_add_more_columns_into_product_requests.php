<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnsIntoProductRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_requests', function (Blueprint $table) {
            //
            $table->char('grade' , 1)->nullable()->after('market_id');
            $table->boolean('is_packing')->nullable()->after('grade');
            $table->smallInteger('packing_size')->nullable()->after('is_packing');
            $table->integer('province_source')->nullable()->after('packing_size');
            $table->integer('province_selling')->nullable()->after('province_source');
            $table->dateTime('start_selling_date')->nullable()->after('province_selling');
            $table->dateTime('end_selling_date')->nullable()->after('start_selling_date');
            $table->char('selling_period' , 4)->nullable()->after('end_selling_date');

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
            $table->dropColumn('grade');
            $table->dropColumn('is_packing');
            $table->dropColumn('packing_size');
            $table->dropColumn('province_source');
            $table->dropColumn('province_selling');
            $table->dropColumn('start_selling_date');
            $table->dropColumn('end_selling_date');
            $table->dropColumn('selling_period');
        });
    }
}
