<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrKontrakB3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_kontrak_b3', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipe_limbah');
            $table->decimal('jmlh_limbah',4,2)->nullable();
            $table->integer('harga');
            $table->string('satuan');
            $table->decimal('konsumsi',20,0)->nullable();
            // $table->decimal('sisa',20,0)->nullable();
            $table->year('tahun')->nullable();
            $table->string('np');
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
        Schema::dropIfExists('tr_kontrak_b3');
    }
}
