<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class AddStoreIdGeneratePromocodeTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generate_promocode_tokens', function (Blueprint $table) {
            $table->bigInteger("store_id")->nullable()->unsigned()->after("promocode_id");
            $table->bigInteger("coupon_id")->nullable()->unsigned()->after("store_id");

            $table->foreign('store_id')->references('id')->on('stores');
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
        Schema::table('generate_promocode_tokens', function (Blueprint $table) {
            $table->dropColumn('store_id');
            $table->dropColumn('coupon_id');
        });
    }
}
