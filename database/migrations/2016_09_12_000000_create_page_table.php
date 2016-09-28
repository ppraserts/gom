<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration
{

    public function up()
    {
        Schema::create('Pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_title_th');
            $table->string('page_title_en');
            $table->text('page_description_th');
            $table->text('page_description_en');
            $table->float('page_latitude');
            $table->float('page_longitude');
            $table->boolean('page_is_contact');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("Pages");
    }
}
?>
