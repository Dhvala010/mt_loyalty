<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $user_roles;

    public function __construct()
    {
        $this->user_roles = config('loyalty.user_role');
        $p = $this->user_roles;
        $args = "";
        array_walk(
            $p,
            function ($item, $key) use (&$args) {
                $args .= $key ." = '" . $item . "' ";
            }
        );
        $this->user_staring = $args;
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $user_roles = $this->user_roles;
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role',$user_roles)->comment($this->user_staring);
            $table->bigInteger('country_code')->unsigned()->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fbid')->nullable();
            $table->string('gid')->nullable();
            $table->string('tid')->nullable();
            $table->string('profile_picture')->nullable();
            $table->boolean('is_agree_terms')->default(false);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_code')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
