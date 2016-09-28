<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideImageTable extends Migration
{

    public function up()
    {
        Schema::create('SlideImages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slideimage_name');
            $table->string('slideimage_file');
            $table->string('slideimage_type');
            $table->string('slideimage_urllink');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("SlideImages");
    }
}
?>
