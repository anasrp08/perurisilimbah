<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSaldo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_saldo', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->bigInteger('idlimbah')->unsigned()->nullable();
            $table->foreign('idlimbah')->references('id')->on('md_namalimbah')->onDelete('cascade');
            $table->bigInteger('idtps')->unsigned()->nullable();
            $table->foreign('idtps')->references('id')->on('md_tps')->onDelete('cascade'); 
            $table->integer('saldo_masuk'); 
            $table->integer('saldo_keluar'); 
            $table->integer('saldo_sisa'); 
            $table->integer('bulan'); 
            $table->year('tahun');  
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
        Schema::dropIfExists('tr_saldo');
    }
}
