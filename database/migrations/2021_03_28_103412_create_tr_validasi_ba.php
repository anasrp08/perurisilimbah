<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrValidasiBa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_validasi_ba', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_detail')->unsigned()->nullable();
            $table->foreign('id_detail')->references('id')->on('tr_detailmutasi')->onDelete('cascade');
            $table->bigInteger('id_mutasi')->unsigned()->nullable();
            $table->foreign('id_mutasi')->references('id')->on('tr_headermutasi')->onDelete('cascade');
            $table->string('np_pemohon')->nullable();
            $table->datetime('validated_pemohon')->nullable();
            $table->string('np_pengawas')->nullable();
            $table->datetime('validated_pengawas')->nullable();
            $table->string('np_pengawas_lapangan')->nullable();
            $table->datetime('validated_np_pengawas_lapangan')->nullable();
            $table->text('keterangan_proses')->nullable();
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
        Schema::dropIfExists('tr_validasi_ba');
    }
}
