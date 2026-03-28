<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToApplicantExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_exp_info', function (Blueprint $table) {
            $table->string('appointment_doc',255)->nullable();
            $table->string('termination_doc',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_exp_info', function (Blueprint $table) {
//            $table->string('appointment_doc',255)->nullable();
//            $table->string('termination_doc',255)->nullable();
        });
    }
}
