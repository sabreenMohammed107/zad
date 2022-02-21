<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Relation1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  This is Realations for the categories Table ..
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('language_id')->references('id')->on('languages');

        });

         //  This is Realations for the subcategories Table ..
         Schema::table('subcategories', function (Blueprint $table) {
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('category_id')->references('id')->on('categories');

        });

        //  This is Realations for the questions Table ..
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('language_id')->references('id')->on('languages');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('sub_category_id')->references('id')->on('subcategories');
            $table->foreign('level_id')->references('id')->on('question_levels');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
