<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadDocumentTable extends Migration
{

    public function up()
    {
        Schema::create('DownloadDocuments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('downloaddocument_title_th');
            $table->text('downloaddocument_description_th');
            $table->string('downloaddocument_title_en');
            $table->text('downloaddocument_description_en');
            $table->string('downloaddocument_file');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("DownloadDocuments");
    }
}
?>
