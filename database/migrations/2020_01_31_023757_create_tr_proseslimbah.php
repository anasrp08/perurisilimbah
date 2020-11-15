<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrProseslimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_detailmutasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_transaksi');
            $table->bigInteger('idmutasi')->unsigned()->nullable();
            $table->foreign('idmutasi')->references('id')->on('tr_headermutasi')->onDelete('cascade');
            $table->bigInteger('idlimbah')->unsigned()->nullable();
            $table->foreign('idlimbah')->references('id')->on('md_namalimbah')->onDelete('cascade');
            $table->bigInteger('idjenislimbah')->unsigned()->nullable();
            $table->foreign('idjenislimbah')->references('id')->on('md_jenislimbah')->onDelete('cascade');
            $table->bigInteger('idstatus')->unsigned()->nullable();
            $table->foreign('idstatus')->references('id')->on('md_statusmutasi')->onDelete('cascade');
            $table->bigInteger('idasallimbah')->unsigned()->nullable();
            $table->foreign('idasallimbah')->references('id')->on('md_penghasillimbah')->onDelete('cascade');
            $table->bigInteger('idtps')->unsigned()->nullable();
            $table->foreign('idtps')->references('id')->on('md_tps')->onDelete('cascade');
            $table->date('tgl'); 
            $table->integer('jumlah');  
            $table->bigInteger('idsatuan')->unsigned()->nullable();
            $table->foreign('idsatuan')->references('id')->on('md_satuan')->onDelete('cascade');
            $table->integer('jumlah_out');  
            $table->string('np')->nullable();
            $table->string('created_by')->nullable();
            $table->string('changed_by')->nullable();
            $table->string('limbah3r')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::table('tr_detailmutasi', function (Blueprint $table) {
            // $table->dropForeign(['idlimbah']);
            // $table->dropForeign(['idjenislimbah']);
            // $table->dropForeign(['idtps']);
            // $table->dropForeign(['idvendor']);
            // $table->dropColumn(['idjenislimbah','idvendor']);
        });
        Schema::dropIfExists('tr_detailmutasi'); 
        Schema::enableForeignKeyConstraints();
    }
}
