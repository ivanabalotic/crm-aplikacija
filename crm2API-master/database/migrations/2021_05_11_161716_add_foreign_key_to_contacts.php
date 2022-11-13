<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->foreign('company_id')->references('id')->on('companies');


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->fropForeign(['staff_id']);
            $table->fropForeign(['stage_id']);
            $table->fropForeign(['company_id']);
        });
    }
}
