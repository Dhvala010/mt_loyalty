<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTyUserStampGenerate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_stamp_collects', function (Blueprint $table) {
            $table->string("count")->after("user_id")->nullable();
            $table->boolean("is_redeem")->after("count")->default(false);
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
            $table->dropColumn("count");
            $table->dropColumn("is_redeem");
        });
    }
}
