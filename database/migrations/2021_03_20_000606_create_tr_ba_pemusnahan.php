<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrBaPemusnahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_ba_pemusnahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_transaksi');
            $table->integer('no_ba');
            $table->bigInteger('idmutasi')->unsigned()->nullable();
            $table->foreign('idmutasi')->references('id')->on('tr_headermutasi')->onDelete('cascade');
            $table->bigInteger('idlimbah')->unsigned()->nullable();
            $table->foreign('idlimbah')->references('id')->on('md_namalimbah')->onDelete('cascade');
            $table->bigInteger('idsatuan')->unsigned()->nullable();
            $table->foreign('idsatuan')->references('id')->on('md_satuan')->onDelete('cascade');
            $table->string('no_dokumen')->nullable();
            $table->date('tgl'); 
            $table->string('nama_petugas')->nullable();
            $table->string('np_petugas')->nullable();
            $table->string('keterangan_petugas')->nullable();
            $table->text('cara_pemusnahan')->nullable();
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
        Schema::dropIfExists('tr_ba_pemusnahan');
    }
}
