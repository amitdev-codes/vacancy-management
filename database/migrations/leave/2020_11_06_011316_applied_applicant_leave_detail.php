<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppliedApplicantLeaveDetail extends Migration
{
    /**P
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_applicant_leave_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_no')->nullable();
            $table->unsignedInteger('applicant_id')->nullable();
            $table->unsignedInteger('vacancy_apply_id')->nullable();
            $table->foreign('applicant_id')->references('id')->on('applicant_profile');
            $table->unsignedSmallInteger('leave_type_id')->nullable();
            $table->foreign('leave_type_id')->references('id')->on('mst_leave_type');
            $table->string('date_from_bs', 100)->nullable();
            $table->string('date_to_bs', 100)->nullable();
            $table->date('date_from_ad')->nullable();
            $table->date('date_to_ad')->nullable();
            $table->string('file_uploads', 255)->nullable();
            $table->string('remarks', 500)->nullable();
            $table->boolean('is_deleted')->default(0);
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
        Schema::dropIfExists('applied_applicant_leave_detail');
    }
}
