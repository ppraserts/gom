<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTable extends Migration
{

    public function up()
    {
        Schema::create('ProductCategorys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('productcategory_title_th');
            $table->text('productcategory_description_th');
            $table->string('productcategory_title_en');
            $table->text('productcategory_description_en');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("ProductCategorys");
    }
}
?>
