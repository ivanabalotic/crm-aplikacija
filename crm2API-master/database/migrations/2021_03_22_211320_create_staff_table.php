<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->date('created_at');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');//sales or manager
            $table->boolean('status');
            $table->bigInteger('manager_id')->unsigned()->nullable();

            $table->foreign('manager_id')->references('id')->on('staff');//if the staff is of role sales then it has id of its manager
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
