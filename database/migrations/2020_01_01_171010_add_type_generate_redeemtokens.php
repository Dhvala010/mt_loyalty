<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeGenerateRedeemtokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generate_redeemtokens', function (Blueprint $table) {
            $table->enum('type',["stamp","point","coupon"])->after("unique_token")->default("stamp");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generate_redeemtokens', function (Blueprint $table) {
            $table->dropColumn("type");
        });
    }
}
