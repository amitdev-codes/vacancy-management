<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMergedApplicant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merged_applicant_leave_detail', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->nullable();
            $table->boolean('is_verified')->default(false)->nullable();
            $table->string('flag')->nullable();
            $table->string('mismatched_key')->nullable();
            $table->unsignedInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('cms_users');
            $table->unsignedInteger('verified_by')->nullable();
            $table->foreign('verified_by')->references('id')->on('cms_users');
            $table->timestamp('verified_on')->nullable();
            $table->timestamp('approved_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merged_applicant_leave_detail', function (Blueprint $table) {
            //
        });
    }
}
