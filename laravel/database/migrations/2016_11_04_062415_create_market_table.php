<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketTable extends Migration
{

    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('market_title_th');
            $table->text('market_description_th');
            $table->string('market_title_en');
            $table->text('market_description_en');
            $table->string('marketimage_file');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("markets");
    }
}
?>
