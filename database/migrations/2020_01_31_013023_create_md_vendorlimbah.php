<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdVendorlimbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_vendorlimbah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('namavendor');
            $table->string('jenislimbah');
            $table->string('tipelimbah');
            $table->string('fisik');
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
        Schema::dropIfExists('md_vendorlimbah');
    }
}
