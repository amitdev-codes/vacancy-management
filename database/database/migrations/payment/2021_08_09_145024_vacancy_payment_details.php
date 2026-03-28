<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VacancyPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancy_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('vacancy_post_id')->nullable();
            $table->unsignedInteger('designation_id')->nullable();
            $table->unsignedInteger('applicant_id')->nullable();
            $table->unsignedInteger('psp_id')->nullable();
            $table->unsignedInteger('csv_payment_file_id')->nullable();
            $table->unsignedInteger('importer_user_id')->nullable();
            $table->date('imported_date_ad')->nullable();
            $table->string('imported_date_bs', 10)->nullable();
            $table->string('token_number_text', 50)->nullable();
            $table->string('token_number', 50)->nullable();
            $table->unsignedInteger('amount_paid')->nullable();
            $table->string('receipt_number', 50)->nullable();
            $table->date('receipt_date_ad')->nullable();
            $table->string('applicant_name', 200)->nullable();
            $table->string('remarks', 500)->nullable();
            $table->boolean('is_linked')->nullable()->default(false);
            $table->unsignedInteger('linked_application_id')->nullable();
            $table->boolean('is_email_sent')->nullable()->default(false);
            $table->date('email_sent_date_ad')->nullable();
            $table->unsignedInteger('webpayment_id')->nullable();
            $table->unsignedInteger('tokenpayment_id')->nullable();
            $table->string('receipt_path')->nullable();
            $table->string('txn_id')->nullable();

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
        Schema::dropIfExists('vacancy_payment_details');
    }
}
