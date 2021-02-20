<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdNamalimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_namalimbah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('namalimbah');
            $table->string('satuan');
            $table->string('tipelimbah');
            $table->string('jenislimbah');
            $table->string('fisik');
            $table->integer('saldo');
            $table->integer('is_lgsg_proses');
            
            $table->string('keterangan');
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
        Schema::dropIfExists('md_namalimbah');
    }
}
