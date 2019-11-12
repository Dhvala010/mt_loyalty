<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('device_unique_id',255)->nullable();
            $table->string('device_type')->nullable();
            $table->longText('fcm_token')->nullable();
            $table->string('device_os')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_manufacturer')->nullable();
            $table->string('api_version')->nullable();
            $table->string('app_version')->nullable();
            $table->string('buildtype')->nullable();
            $table->string('buildversion')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_devices');
    }
}
