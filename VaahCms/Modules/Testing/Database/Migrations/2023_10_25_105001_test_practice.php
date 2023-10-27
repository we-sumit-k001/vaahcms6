<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestPractice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('test_practice', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable()->index();

            $table->bigInteger('test_id')->nullable()->index();

            $table->bigInteger('practice_id')->nullable()->index();

            //----common fields
            $table->text('meta')->nullable();
            $table->integer('created_by')->nullable()->index();
            $table->integer('updated_by')->nullable()->index();
            $table->integer('deleted_by')->nullable()->index();
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
        Schema::dropIfExists('test_practice');
    }
}
