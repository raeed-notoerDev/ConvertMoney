<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('user_name')->unique();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('ref_id')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('nationality');
            $table->string('status');
            $table->string('picture')->nullable();
            $table->string('address');
            $table->string('agent_commission')->nullable();
            $table->string('uuid')->unique();
            $table->string('phone_number')->unique();
            $table->string('verify_phone_number')->nullable();
            $table->float('wallet')->default(0);
            $table->integer('country_id');
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
