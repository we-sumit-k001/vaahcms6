<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestPracticeCrud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('test_practice_crud', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable()->index();

            $table->bigInteger('practice_id')->unsigned()->nullable()->index();
            $table->foreign('practice_id')->references('id')->on('vh_training');
            $table->bigInteger('test_id')->unsigned()->nullable()->index();
            $table->foreign('test_id')->references('id')->on('vh_test');

            $table->boolean('is_active')->nullable()->index();

            //----common fields
            $table->text('meta')->nullable();
            $table->integer('created_by')->nullable()->index();
            $table->integer('updated_by')->nullable()->index();
            $table->integer('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at', 'updated_at', 'deleted_at']);

        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('test_practice_crud');
    }
}
