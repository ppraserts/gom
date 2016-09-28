<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutUsTable extends Migration
{

    public function up()
    {
        Schema::create('AboutUs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('aboutus_description_th');
            $table->text('aboutus_description_en');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("AboutUs");
    }
}
?>
