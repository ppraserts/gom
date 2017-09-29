<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqCategoryTable extends Migration
{

    public function up()
    {
        Schema::create('FaqCategorys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('faqcategory_title_th');
            $table->text('faqcategory_description_th');
            $table->string('faqcategory_title_en');
            $table->text('faqcategory_description_en');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("FaqCategorys");
    }
}
?>
