<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                Schema::create('News', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('news_title_th');
                    $table->text('news_description_th');
                    $table->string('news_title_en');
                    $table->text('news_description_en');
                    $table->date('news_created_at');
                    $table->text('news_place');
                    $table->string('news_tags');
                    $table->string('news_sponsor');
                    $table->string('news_document_file')->default("");
                    $table->integer('sequence');
                    $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::drop("News");
    }
}
