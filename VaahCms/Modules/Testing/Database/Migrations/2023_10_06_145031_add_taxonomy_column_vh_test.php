<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxonomyColumnVhTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('vh_test', function (Blueprint $table) {

            $table->integer('parent_id')->nullable()->index();
            $table->integer('hw_taxonomies_type_id')->nullable()->index();

        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('vh_test', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('hw_taxonomies_type_id');
        });


    }
}
