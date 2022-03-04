<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('bid_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->boolean('status')->default(false);
            $table->boolean('user_delete')->default(false);
            $table->boolean('customer_delete')->default(false);
            $table->boolean('seen_or_unseen')->default(false);
            $table->timestamps();
        });



        Schema::table('transactions', function ($table) {
            
             $table->foreign('bid_id')->references('id')->on('bids')->onDelete('cascade')->onUpdate('cascade');
             $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
             $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
