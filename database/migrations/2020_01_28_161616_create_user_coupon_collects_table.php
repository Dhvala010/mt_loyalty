<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCouponCollectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coupon_collects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("store_id")->unsigned();
            $table->bigInteger("coupon_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->string("count");
            $table->timestamps();

            $table->foreign('coupon_id')->references('id')->on('store_coupons');
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
        Schema::dropIfExists('user_coupon_collects');
    }
}
