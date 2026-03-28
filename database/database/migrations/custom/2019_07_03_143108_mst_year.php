<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MstYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('mst_year')){
        Schema::create('mst_year', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('code',10);
            $table->string('year_bs',100);
            $table->string('year_ad',100);
            $table->timestamps();
        
        });
    }
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
