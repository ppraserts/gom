<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqTable extends Migration
{

    public function up()
    {
        Schema::create('Faq', function (Blueprint $table) {
            $table->increments('id');
            $table->string('faq_question_th');
            $table->text('faq_answer_th');
            $table->string('faq_question_en');
            $table->text('faq_answer_en');
            $table->integer('sequence');
            $table->timestamps();
            $table->integer('faqcategory_id')->unsigned()->nullable();
        });

        Schema::table('Faq', function($table) {
            $table->foreign('faqcategory_id')->references('id')->on('FaqCategorys');
        });
    }

    public function down()
    {
        Schema::drop("Faq");
    }
}
?>
