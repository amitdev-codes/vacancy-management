<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpsWebCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ips_web_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('counter_id')->nullable();
            $table->string('app_id')->nullable();
            $table->string('app_name')->nullable();
            $table->string('ips_login_url')->nullable();
            $table->string('ips_web_verification_url')->nullable();
            $table->string('ips_transactions_details_url')->nullable();
            $table->string('ips_success_url')->nullable();
            $table->string('ips_failure_url')->nullable();
            $table->string('ips_merchant_id')->nullable();
            $table->string('ips_username')->nullable();
            $table->string('ips_password')->nullable();
            $table->string('pfx_file_name')->nullable();
            $table->string('cert_password')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->index('counter_id', 'idx_ips_counter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ips_web_credentials');
    }
}
