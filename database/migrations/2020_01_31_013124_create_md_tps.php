<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdTps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_tps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('namatps');
            $table->string('jenislimbah');
            $table->string('tipelimbah');
            $table->string('kapasitasarea');
            $table->string('satuan1');
            $table->string('kapasitasjumlah');
            $table->string('satuan2');
            $table->string('fisik');
            $table->integer('tahun');
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
        Schema::dropIfExists('md_tps');
    }
}
