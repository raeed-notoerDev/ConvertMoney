<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('agent_id_sender');
            $table->string('agent_id_receiver')->nullable();
            $table->float('tax')->nullable();
            $table->float('commission');
            $table->float('convert_price');
            $table->float('total_money');
            $table->integer('destination_country_id');
            $table->string('currency_sender_id');
            $table->string('currency_receiver_id');
            $table->string('receiver_country_id');
            $table->string('status');
            $table->string('sender_beneficiary_id');
            $table->string('receiver_beneficiary_id');
            $table->string('photos')->nullable();
            $table->date('delivered_at')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
