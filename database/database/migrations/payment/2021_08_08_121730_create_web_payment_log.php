<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPaymentLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_payment_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('psp_id')->nullable();
            $table->unsignedInteger('applicant_id')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->unsignedInteger('applicant_token')->nullable();
            $table->string('notice_no')->nullable();
            $table->string('advertisement_no')->nullable();
            $table->date('applied_date_ad')->nullable();
            $table->string('applied_date_bs')->nullable();
            $table->string('applied_group')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();

            $table->string('eservice_trans_ref_code', 255)->nullable();
            #pspcode
            $table->string('process_step', 255)->nullable();
            $table->string('psp_code', 255)->nullable();
            $table->string('psp_trans_ref_code', 255)->nullable();
            $table->string('psp_reference_token', 255)->nullable();
            $table->string('psp_product', 255)->nullable();
            $table->boolean('psp_payment_status')->nullable();
            $table->string('psp_payment_message', 255)->nullable();
            #psp verification
            $table->boolean('psp_verification_status')->nullable();
            $table->dateTime('psp_verification_datetime')->nullable();
            $table->string('psp_verification_message', 255)->nullable();
            $table->decimal('total_paid_amount', 10, 2)->nullable();
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
        Schema::dropIfExists('web_payment_log');
    }
}
