<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrMutasilimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_headermutasi', function (Blueprint $table) {
            // $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('idlimbah')->unsigned()->nullable();
            $table->foreign('idlimbah')->references('id')->on('md_namalimbah')->onDelete('cascade');
            $table->bigInteger('idasallimbah')->unsigned()->nullable();
            $table->foreign('idasallimbah')->references('id')->on('md_penghasillimbah')->onDelete('cascade');
            $table->bigInteger('idjenislimbah')->unsigned()->nullable();
            $table->foreign('idjenislimbah')->references('id')->on('md_jenislimbah')->onDelete('cascade');
            $table->bigInteger('idtps')->unsigned()->nullable();
            $table->foreign('idtps')->references('id')->on('md_tps')->onDelete('cascade');
            $table->bigInteger('idvendor')->unsigned()->nullable();
            $table->foreign('idvendor')->references('id')->on('md_vendorlimbah')->onDelete('cascade');
            $table->string('no_manifest')->nullable();
            $table->string('no_spbe')->nullable();
            $table->string('no_kendaraan')->nullable();
            $table->date('tgl'); 
            $table->integer('jumlah');  
            $table->string('limbah3r')->nullable();
            $table->string('np')->nullable();
            $table->string('created_by')->nullable();
            $table->string('changed_by')->nullable();
            $table->string('keterangan')->nullable();
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
        // Schema::table('tr_headermutasi', function (Blueprint $table) {
        //     $table->dropForeign(['idlimbah']);
        //     $table->dropForeign(['idjenislimbah']);
        //     $table->dropForeign(['idtps']);
        //     $table->dropForeign(['idvendor']);
        //     $table->dropColumn(['idlimbah','idjenislimbah','idtps','idvendor']);
        // });
        Schema::dropIfExists('tr_headermutasi');
        Schema::enableForeignKeyConstraints();

    }
}
