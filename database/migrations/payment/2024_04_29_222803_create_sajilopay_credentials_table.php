<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSajilopayCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sajilopay_credentials', function (Blueprint $table) {
            $table->id();
            $table->integer('counter_id')->nullable();
            $table->string('app_id')->nullable();
            $table->string('app_name')->nullable();
            $table->string('sajilopay_login_url')->nullable();
            $table->string('sajilopay_web_verification_url')->nullable();
            $table->string('sajilopay_success_url')->nullable();
            $table->string('sajilopay_failure_url')->nullable();
            $table->string('sajilopay_transaction_details_url')->nullable();
            $table->string('sajilopay_secret_key')->nullable();
            $table->string('sajilopay_public_key')->nullable();
            $table->string('sajilopay_product_url')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->index('counter_id', 'idx_sajilopay_counter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sajilopay_credentials');
    }
}
