<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsFormTable extends Migration
{

    public function up()
    {
        Schema::create('ContactUsForm', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contactusform_name');
            $table->string('contactusform_surname');
            $table->string('contactusform_email');
            $table->string('contactusform_phone');
            $table->string('contactusform_file');
            $table->string('contactusform_subject');
            $table->text('contactusform_messagebox');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("ContactUsForm");
    }
}
?>
