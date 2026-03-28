<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenPaymentLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psp_token_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ipaddress', 50)->nullable();
            $table->string('useragent')->nullable();
            $table->unsignedInteger('psp_id')->nullable();
            $table->unsignedInteger('applicant_id')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->unsignedInteger('applicant_token')->nullable();
            $table->string('applied_group')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            #validation api first
            $table->string('process_step1')->nullable();
            $table->string('validation_pspcode')->nullable();
            $table->string('validation_key')->nullable();
            $table->string('validation_applicant_token')->nullable();
            $table->boolean('validation_status')->default(false);
            $table->string('validation_message')->nullable();
            $table->string('validation_unique_generated_token')->nullable();
            $table->dateTime('validation_time')->nullable();
            #inquirystep api second
            $table->string('process_step2')->nullable();
            $table->unsignedInteger('inquiry_token')->nullable();
            $table->boolean('inquiry_status')->default(false);
            $table->string('inquiry_message')->nullable();
            $table->dateTime('inquiry_time')->nullable();

            #payment initiated api 4th
            $table->string('process_step3')->nullable();
            $table->unsignedInteger('payment_token')->nullable();
            $table->string('tax_paid_amount', 100)->nullable();
            $table->string('eservice_transaction_code', 255)->nullable();
            $table->string('psp_transaction_code', 255)->nullable();
            $table->boolean('payment_verification_status')->default(false);
            $table->string('payment_verification_message', 255)->nullable();
            $table->dateTime('payment_verification_time')->nullable();
            #munerp details
            $table->boolean('ntc_update_status')->nullable();
            $table->dateTime('ntc_update_datetime')->nullable();
            $table->string('ntc_update_message', 255)->nullable();
            $table->string('paid_receipt_no')->nullable();
            $table->string('paid_receipt_date_bs')->nullable();
            $table->date('paid_receipt_date_ad')->nullable();

            $table->boolean('is_deleted', 1)->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psp_token_payment_logs');
    }
}
