<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNamastepayWebCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('namastepay_web_credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('counter_id')->nullable();
            $table->string('app_id')->nullable();
            $table->string('app_name')->nullable();
            $table->string('namastepay_loginUrl')->nullable();
            $table->string('namastepay_tokenGenerationUrl')->nullable();
            $table->string('namastepay_identifierValue')->nullable();
            $table->string('namastepay_authenticationValue')->nullable();
            $table->string('namastepay_otpGenerationUrl')->nullable();
            $table->string('namastepay_validateOtpUrl')->nullable();
            $table->string('namastepay_resendOtpUrl')->nullable();
            $table->string('namastepay_transactionDetailsUrl')->nullable();
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
        Schema::dropIfExists('namastepay_web_credentials');
    }
}
