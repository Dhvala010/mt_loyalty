<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCollectCouponTabeleAddIsReward extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_coupon_collects', function (Blueprint $table) {
            $table->string("is_redeem")->nullable()->after("count");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_coupon_collects', function (Blueprint $table) {
            $table->dropColumn('is_redeem');
        });
    }
}
