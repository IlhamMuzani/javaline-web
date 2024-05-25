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
        Schema::create('detail_buktis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tagihan_ekspedisi_id')->nullable();
            $table->foreign('tagihan_ekspedisi_id')->references('id')->on('tagihan_ekspedisis');
            $table->unsignedBigInteger('bukti_potongpajak_id')->nullable();
            $table->foreign('bukti_potongpajak_id')->references('id')->on('bukti_potongpajaks');
            $table->string('kode_tagihan')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('detail_buktis');
    }
};