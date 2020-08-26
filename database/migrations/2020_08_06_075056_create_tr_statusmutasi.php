<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrStatusmutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_statusmutasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idmutasi')->unsigned()->nullable(); 
            $table->foreign('idmutasi')->references('id')->on('tr_headermutasi')->onDelete('cascade');
            $table->bigInteger('idlimbah')->unsigned()->nullable();
            $table->foreign('idlimbah')->references('id')->on('md_namalimbah')->onDelete('cascade');
            $table->bigInteger('idtps')->unsigned()->nullable();
            $table->foreign('idtps')->references('id')->on('md_tps')->onDelete('cascade');
            $table->bigInteger('idstatus')->unsigned()->nullable();
            $table->foreign('idstatus')->references('id')->on('md_statusmutasi')->onDelete('cascade');
            $table->bigInteger('idasallimbah')->unsigned()->nullable();
            $table->foreign('idasallimbah')->references('id')->on('md_penghasillimbah')->onDelete('cascade');
            $table->bigInteger('idjenislimbah')->unsigned()->nullable();
            $table->foreign('idjenislimbah')->references('id')->on('md_jenislimbah')->onDelete('cascade');
            $table->integer('jumlah'); 
            $table->string('limbah3r'); 
            $table->date('tgl'); 
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
        // Schema::table('tr_statusmutasi', function (Blueprint $table) {
        //     $table->dropForeign(['idmutasi']);
        //     $table->dropForeign(['idlimbah']);
        //     $table->dropForeign(['idtps']);
        //     $table->dropForeign(['idstatus']);
        //     $table->dropColumn(['idmutasi','idlimbah','idtps','idstatus']);
        // }); 
        Schema::dropIfExists('tr_statusmutasi');
        Schema::enableForeignKeyConstraints();
    }
}
