<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileColumnVhTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('vh_training', function (Blueprint $table) {

            $table->string('file_link')->nullable()->index();

        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('vh_training', function (Blueprint $table) {
            $table->dropColumn('file_link');
        });
    }
}
