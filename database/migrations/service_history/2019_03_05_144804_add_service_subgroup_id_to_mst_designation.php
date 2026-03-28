<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceSubgroupIdToMstDesignation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_designation', function ($table) {
            $table->unsignedSmallInteger('service_subgroup_id')->nullable();
            $table->foreign('service_group_id')->references('id')->on('mst_work_service_sub_group');
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
