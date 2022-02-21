<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('sub_category_id')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('question_type')->default(1)->comment('1=>normal , 2=>true\false');
            $table->text('option_a')->nullable();
            $table->text('option_b')->nullable();
            $table->text('option_c')->nullable();
            $table->text('option_d')->nullable();
            $table->text('option_e')->nullable();
            $table->text('answer')->nullable();
            $table->foreignId('level_id')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
