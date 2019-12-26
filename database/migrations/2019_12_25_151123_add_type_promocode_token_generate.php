<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypePromocodeTokenGenerate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generate_promocode_tokens', function (Blueprint $table) {
            $table->enum('type',["stamp","point","coupon"])->after("unique_token")->default("stamp");
            $table->string("count")->after("type")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generate_promocode_tokens', function (Blueprint $table) {
            $table->dropColumn("type");
            $table->dropColumn("count");
        });
    }
}
