<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->string('full_name');
            $table->string('phone_number')->unique();
            $table->string('passport_number')->nullable();
            $table->string('id_number')->unique();
            $table->string('address')->nullable();
            $table->string('birthday')->nullable();
            $table->string('nationality')->nullable();
            $table->string('gender')->nullable();
            $table->string('profession')->nullable();// career     // job
            $table->string('other_info')->nullable();// career     // job
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
        Schema::dropIfExists('beneficiaries');
    }
}
