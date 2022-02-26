<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firebase_id')->nullable();
            $table->string('mobile');
            $table->enum('type',['email','gmail','fb','mobile','apple']);
            $table->string('profile')->nullable();
            $table->string('fcm_id')->nullable();
            $table->integer('coins')->default(0);
            $table->string('refer_code')->nullable();
            $table->string('friends_code')->nullable();
            $table->boolean('status')->default(0);



            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
