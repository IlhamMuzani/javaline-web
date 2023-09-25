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
        Schema::create('bans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ban')->nullable();
            $table->string('no_seri')->nullable();
            // $table->unsignedBigInteger('supplier_id')->nullable();
            // $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->unsignedBigInteger('pembelian_ban_id')->nullable();
            $table->foreign('pembelian_ban_id')->references('id')->on('pembelian_bans')->onDelete('set null');
            $table->unsignedBigInteger('ukuran_id')->nullable();
            $table->foreign('ukuran_id')->references('id')->on('ukurans')->onDelete('set null');
            $table->string('kondisi_ban')->nullable();
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('merek_id')->nullable();
            $table->foreign('merek_id')->references('id')->on('mereks')->onDelete('set null');
            $table->unsignedBigInteger('typeban_id')->nullable();
            $table->foreign('typeban_id')->references('id')->on('typebans')->onDelete('set null');
            $table->string('harga')->nullable();
            $table->string('umur_ban')->nullable();
            $table->string('km_pemasangan')->nullable();
            $table->string('km_pelepasan')->nullable();
            $table->string('target_km_ban')->nullable();
            $table->string('posisi_ban')->nullable();
            $table->string('qrcode_ban')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->unsignedBigInteger('pemasangan_ban_id')->nullable();
            $table->foreign('pemasangan_ban_id')->references('id')->on('pemasangan_bans')->onDelete('set null');
            $table->unsignedBigInteger('pelepasan_ban_id')->nullable();
            $table->foreign('pelepasan_ban_id')->references('id')->on('pelepasan_bans')->onDelete('set null');
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
        Schema::dropIfExists('bans');
    }
};