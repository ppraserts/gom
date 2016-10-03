<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->boolean('is_admin')->default(false);
          $table->boolean('is_active')->default(false);
          $table->renameColumn('name', 'users_firstname_th');
          $table->string('users_lastname_th');
          $table->string('users_firstname_en');
          $table->string('users_lastname_en');
          $table->date('users_dateofbirth');
          $table->enum('users_gender', ['male', 'female']);
          $table->string('users_addressname');
          $table->string('users_street');
          $table->string('users_district');
          $table->string('users_city');
          $table->string('users_province');
          $table->string('users_postcode');
          $table->string('users_mobilephone');
          $table->string('users_phone');
          $table->string('users_fax');
          $table->string('users_imageprofile');
          $table->decimal('users_latitude', 11, 8);
          $table->decimal('users_longitude', 11, 8);
          $table->string('users_contactperson');
          $table->enum('users_membertype', ['personal', 'company']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
