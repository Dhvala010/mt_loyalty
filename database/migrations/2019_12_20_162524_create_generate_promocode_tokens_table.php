<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratePromocodeTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate_promocode_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("promocode_id")->unsigned()->nullable();
            $table->string("unique_token")->nullable();
            $table->timestamps();

            $table->foreign('promocode_id')->references('id')->on('store_promocodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generate_promocode_tokens');
    }
}
