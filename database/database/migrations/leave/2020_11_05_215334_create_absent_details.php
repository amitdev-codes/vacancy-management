<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_absent_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_no')->nullable();
            $table->string('date_from_bs', 100)->nullable();
            $table->string('date_to_bs', 100)->nullable();
            $table->date('date_from_ad')->nullable();
            $table->date('date_to_ad')->nullable();
            $table->timestamp('imported_at')->nullable();
            $table->unsignedInteger('imported_by');
            $table->foreign('imported_by')->references('id')->on('cms_users');
            $table->string('imported_mode')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->string('remarks', 500)->nullable();
            $table->unsignedInteger('erp_file_uploads_id');
            $table->foreign('erp_file_uploads_id')->references('id')->on('erp_file_uploads');
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
        Schema::dropIfExists('erp_absent_details');
    }
}
