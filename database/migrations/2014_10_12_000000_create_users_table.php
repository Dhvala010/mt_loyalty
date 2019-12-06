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

    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $user_roles = config('loyalty.user_role');
        $user_staring = "";
        array_walk( $user_roles,
            function ($item, $key) use (&$user_staring) {
                $user_staring .= $key ." = '" . $item . "' ";
            }
        );

        Schema::create('users', function (Blueprint $table) use( $user_roles ,$user_staring) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role',$user_roles)->comment($user_staring);            
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
