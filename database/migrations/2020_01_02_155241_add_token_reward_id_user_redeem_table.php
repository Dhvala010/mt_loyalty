<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenRewardIdUserRedeemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_redeems', function (Blueprint $table) {
            $table->bigInteger("reward_id")->unsigned()->nullable()->after("offer_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_redeems', function (Blueprint $table) {
            $table->dropColumn("reward_id");
        });
    }
}
