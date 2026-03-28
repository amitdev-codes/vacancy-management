<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkServiceToAppliedApplicantServiceHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applied_applicant_service_history', function ($table) {
            $table->unsignedSmallInteger('work_service_id')->nullable();
            $table->foreign('work_service_id')->references('id')->on('mst_work_service');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
