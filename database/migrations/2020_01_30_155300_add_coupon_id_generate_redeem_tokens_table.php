<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponIdGenerateRedeemTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generate_redeem_tokens', function (Blueprint $table) {
            $table->bigInteger('coupon_id')->nullable()->unsigned()->after('reward_id');

            $table->foreign('coupon_id')->references('id')->on('store_coupons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generate_redeem_tokens', function (Blueprint $table) {
            $table->dropColumn('coupon_id');
        });
    }
}
