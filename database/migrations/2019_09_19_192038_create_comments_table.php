<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commenter_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->integer('user_or_customer');
            $table->longText('comment_content');
            $table->timestamps();
        });

        Schema::table('comments', function ($table) {

             $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');

             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
