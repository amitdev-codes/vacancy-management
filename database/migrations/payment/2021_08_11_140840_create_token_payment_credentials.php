<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenPaymentCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_payment_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_name')->nullable();
            $table->string('client_url')->nullable();
            $table->integer('psp_id')->nullable();
            $table->string('psp_code')->nullable();
            $table->string('appkey')->nullable();
            $table->string('psp_servicecode', 255)->nullable();
            $table->string('psp_merchant', 255)->nullable();
            $table->string('psp_token_verification_url')->nullable();
            $table->string('psp_token_auth_key')->nullable();
            $table->string('psp_token_username')->nullable();
            $table->string('psp_token_password')->nullable();
            $table->string('pfx_file_name')->nullable();
            $table->string('cert_password')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
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
        Schema::dropIfExists('token_payment_credentials');
    }
}
