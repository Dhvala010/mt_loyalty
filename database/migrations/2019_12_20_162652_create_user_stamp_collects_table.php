<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStampCollectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stamp_collects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("promocode_id")->unsigned();
            $table->bigInteger("store_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->timestamps();

            $table->foreign('promocode_id')->references('id')->on('store_promocodes');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_stamp_collects');
    }
}
