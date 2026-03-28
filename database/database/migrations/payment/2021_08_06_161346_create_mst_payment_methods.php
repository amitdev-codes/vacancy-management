<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('counter_id')->nullable();
            $table->string('code', 20);
            $table->string('name_en', 200);
            $table->string('name_np', 200);
            $table->boolean('is_webpayment')->nullable()->default(false);
            $table->boolean('is_tokenpayment')->nullable()->default(false);
            $table->string('remarks', 500)->nullable();
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
        Schema::dropIfExists('mst_payment_methods');
    }
}
