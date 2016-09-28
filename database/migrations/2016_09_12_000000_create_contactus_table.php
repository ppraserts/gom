<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsTable extends Migration
{

    public function up()
    {
        Schema::create('ContactUs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('contactus_address_th');
            $table->text('contactus_address_en');
            $table->decimal('contactus_latitude', 11, 8);
            $table->decimal('contactus_longitude', 11, 8);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("ContactUs");
    }
}
?>
