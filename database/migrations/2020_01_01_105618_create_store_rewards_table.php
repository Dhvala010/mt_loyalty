<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_rewards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("store_id");
            $table->string("title")->nullable();
            $table->string("description")->nullable();
            $table->bigInteger("count")->nullable();
            $table->date("offer_valid")->nullable();  
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_rewards');
    }
}
