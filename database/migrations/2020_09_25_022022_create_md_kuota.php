<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdKuota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('md_kuota', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('tipe_limbah');
            $table->decimal('jumlah',20,0)->nullable();
            $table->decimal('konsumsi',20,0)->nullable();
            $table->decimal('sisa',20,0)->nullable();
            $table->year('tahun')->nullable();
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
        Schema::dropIfExists('md_kuota');
    }
}
