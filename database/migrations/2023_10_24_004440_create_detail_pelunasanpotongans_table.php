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
        Schema::create('detail_pelunasanpotongans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_pelunasan_id')->nullable();
            $table->foreign('faktur_pelunasan_id')->references('id')->on('faktur_pelunasans');
            $table->unsignedBigInteger('potongan_penjualan_id')->nullable();
            $table->foreign('potongan_penjualan_id')->references('id')->on('potongan_penjualans');
            $table->string('kode_potonganlain')->nullable();
            $table->string('keterangan_potonganlain')->nullable();
            $table->string('tanggal_potongan')->nullable();
            $table->string('nominallain')->nullable();
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
        Schema::dropIfExists('detail_pelunasanpotongans');
    }
};