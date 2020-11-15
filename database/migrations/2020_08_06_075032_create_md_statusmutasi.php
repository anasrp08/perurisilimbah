<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdStatusmutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_statusmutasi', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('keterangan');
            $table->string('mutasi');
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

       
        Schema::dropIfExists('md_statusmutasi');
    }
}
