<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('address');
            $table->string('address2');
            $table->string('website_url');
            $table->dateTime('follow_up_date');
            $table->text('notes');
            $table->double('deal_size');
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('staff_id')->unsigned();


            // $table->foreign('stage_id')->referenfces('id')->on('stage');
            // $table->foreign('city_id')->references('id')->on('city');
            // $table->foreign('staff_id')->references('id')->on('staff');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
