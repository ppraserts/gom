<?php

use Illuminate\Database\Migrations\Migration;
use App\Standard;

class InsertStandardDataToStandardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('standards')->truncate();
        Schema::enableForeignKeyConstraints();
        $standardNameArr = array('Organic','PGS','GAP','GMP',);
        foreach ($standardNameArr as $standardName){
            $standard = new Standard();
            $standard->name = $standardName;
            $standard->save();
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
        DB::table('standards')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
