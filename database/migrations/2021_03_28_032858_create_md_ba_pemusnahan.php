<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdBaPemusnahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_ba_pemusnahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no');
            // $table->string('unit_kerja')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
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
        Schema::dropIfExists('md_ba_pemusnahan');
    }
}
