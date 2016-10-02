<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{

    public function up()
    {
        Schema::create('Medias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('media_name_en');
            $table->string('media_name_th');
            $table->string('media_urllink');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("Medias");
    }
}
?>
