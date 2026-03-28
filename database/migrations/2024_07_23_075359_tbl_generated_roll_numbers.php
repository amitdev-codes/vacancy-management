<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblGeneratedRollNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_generated_roll_numbers', function (Blueprint $table) {
            $table->id();
            $table->integer('fiscal_year_id');
            $table->integer('post_id');
            $table->integer('ad_id');
            $table->string('add_type')->nullable();
            $table->integer('applicant_id');
            $table->string('roll_number');
            $table->string('exam_center')->nullable();
            $table->boolean('mail_sent_status')->default(false);
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

