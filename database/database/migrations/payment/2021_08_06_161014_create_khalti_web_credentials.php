<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhaltiWebCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khalti_web_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('counter_id')->nullable();
            $table->string('app_id')->nullable();
            $table->string('app_name')->nullable();
            $table->string('khalti_login_url')->nullable();
            $table->string('khalti_web_verification_url')->nullable();
            $table->string('khalti_success_url')->nullable();
            $table->string('khalti_failure_url')->nullable();
            $table->string('khalti_transaction_details_url')->nullable();
            $table->string('khalti_secret_key')->nullable();
            $table->string('khalti_public_key')->nullable();
            $table->string('khalti_product_url')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->index('counter_id', 'idx_khalti_counter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('khalti_web_credentials');
    }
}
