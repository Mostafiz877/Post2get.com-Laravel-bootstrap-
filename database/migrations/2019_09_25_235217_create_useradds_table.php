<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseraddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('useradds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('phone')->nullable();
            $table->longText('current_location')->nullable();
            //$table->text('image')->default('default.png');
            $table->string('image')->default('default.png');
            $table->timestamps();
        });


        Schema::table('useradds', function ($table) {

             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('useradds');
    }
}
