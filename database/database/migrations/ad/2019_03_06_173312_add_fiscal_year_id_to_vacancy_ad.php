<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiscalYearIdToVacancyAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancy_ad', function ($table) {
            $table->unsignedSmallInteger('fiscal_year_id')->nullable();
            $table->foreign('fiscal_year_id')->references('id')->on('mst_fiscal_year');
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
