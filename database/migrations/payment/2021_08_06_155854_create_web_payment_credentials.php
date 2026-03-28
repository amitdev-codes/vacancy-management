<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPaymentCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esewa_web_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('counter_id')->nullable();
            $table->string('esewa_login_url')->nullable();
            $table->string('esewa_web_verification_url')->nullable();
            $table->string('esewa_success_url')->nullable();
            $table->string('esewa_failure_url')->nullable();
            $table->string('esewa_merchant_code')->nullable();
            $table->string('esewa_merchant_key')->nullable();
            $table->string('esewa_merchant_secret')->nullable();
            $table->string('esewa_transaction_details_url')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->index('counter_id', 'idx_esewa_counter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webPayment_credentials');
    }
}
