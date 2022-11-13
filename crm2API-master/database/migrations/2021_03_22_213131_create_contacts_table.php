<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title');
            $table->string('phone');
            $table->string('email');
            $table->string('contact_method'); //email, phone, or no preference
            $table->bigInteger('stage_id')->unsigned()->nullable();
            $table->bigInteger('staff_id')->unsigned();//koji sales rep ima kog kontakta
            $table->bigInteger('company_id')->unsigned()->nullable();

            // $table->foreign('staff_id')->references('id')->on('staff');//fk on table staff
            // $table->foreign('company_id')->references('id')->on('company');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
