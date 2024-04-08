<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pelunasanreturns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_pelunasan_id')->nullable();
            $table->foreign('faktur_pelunasan_id')->references('id')->on('faktur_pelunasans');
            $table->unsignedBigInteger('faktur_ekspedisi_id')->nullable();
            $table->unsignedBigInteger('nota_return_id')->nullable();
            $table->foreign('nota_return_id')->references('id')->on('nota_returns');
            $table->string('kode_potongan')->nullable();
            $table->string('keterangan_potongan')->nullable();
            $table->string('tanggal_return')->nullable();
            $table->string('nominal_potongan')->nullable();
            $table->string('status')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('detail_pelunasanreturns');
    }
};