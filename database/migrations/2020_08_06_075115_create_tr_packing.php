<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrPacking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_packing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_transaksi');
            $table->integer('no_packing');
            $table->string('kode_pack');
            $table->bigInteger('idmutasi')->unsigned()->nullable(); 
            $table->foreign('idmutasi')->references('id')->on('tr_headermutasi')->onDelete('cascade');
            $table->bigInteger('idlimbah')->unsigned()->nullable();
            $table->foreign('idlimbah')->references('id')->on('md_namalimbah')->onDelete('cascade');
            $table->bigInteger('idtps')->unsigned()->nullable();
            $table->foreign('idtps')->references('id')->on('md_tps')->onDelete('cascade'); 
            $table->bigInteger('idstatus')->unsigned()->nullable();
            $table->foreign('idstatus')->references('id')->on('md_statusmutasi')->onDelete('cascade');
            $table->string('tipelimbah');
            $table->date('kadaluarsa');
            $table->string('np')->nullable();
            $table->string('created_by')->nullable();
            $table->string('changed_by')->nullable();
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
        // Schema::table('tr_packing', function (Blueprint $table) {
        //     $table->dropForeign(['idmutasi']);
        //     $table->dropForeign(['idlimbah']);
        //     $table->dropForeign(['idtps']);
        //     $table->dropForeign(['idstatus']);
        //     $table->dropColumn(['idmutasi','idlimbah','idtps','idstatus']);
        // }); 
        Schema::dropIfExists('tr_packing');
        Schema::enableForeignKeyConstraints();
    }
}
