<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenPaymentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psp_token_payment_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('validation_token')->nullable();
            $table->unsignedInteger('applicant_id')->nullable();
            $table->unsignedInteger('applicant_token')->nullable();
            $table->string('pspcode')->nullable();
            $table->string('appkey')->nullable();
            $table->unsignedInteger('designation_id')->nullable();
            $table->string('counter_code')->nullable();
            $table->string('amount')->nullable();
            $table->string('psp_payment_transaction_id')->nullable();
            $table->string('eservice_transaction_id')->nullable();

            $table->timestamp('expiry_date_time')->nullable();
            $table->timestamps();

            $table->index('id', 'idx_psp_token_payment_data_id');
            $table->index('applicant_id', 'idx_psp_token_payment_data_applicant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psp_token_payment_data');
    }
}
