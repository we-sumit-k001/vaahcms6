<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PraticeTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('pratice_tags', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->uuid('uuid')->nullable()->index();

            $table->bigInteger('tag_id')->index();

            $table->bigInteger('practice_id')->index();


            $table->timestamps();

            $table->softDeletes();
            //----/common fields

        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('pratice_tags');
    }
}
