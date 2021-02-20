<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPemrosesLain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pemroses_lain', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl_proses')->nullable();
            $table->string('nama_limbah')->nullable();
            $table->integer('jumlah');  
            $table->string('treatmen')->nullable();
            $table->string('unit_penghasil')->nullable();
            $table->string('np_pemroses')->nullable();
            $table->string('file')->nullable();
            $table->string('satuan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('alasan_revisi')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('tbl_pemroses_lain');
    }
}
