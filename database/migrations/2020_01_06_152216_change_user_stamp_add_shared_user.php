<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserStampAddSharedUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_stamp_collects', function (Blueprint $table) {
            $table->boolean("is_shared")->default(false)->after("is_redeem");
            $table->bigInteger("shared_user")->unsigned()->nullable()->after("is_shared");

            $table->foreign('shared_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_stamp_collects', function (Blueprint $table) {
            $table->dropColumn("is_shared");
            $table->dropColumn("shared_user");
        });
    }
}
