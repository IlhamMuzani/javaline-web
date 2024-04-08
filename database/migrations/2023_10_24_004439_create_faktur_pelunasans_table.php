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
        Schema::create('faktur_pelunasans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('tagihan_ekspedisi_id')->nullable();
            $table->foreign('tagihan_ekspedisi_id')->references('id')->on('tagihan_ekspedisis');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans');
            $table->string('kode_tagihan')->nullable();
            $table->string('kategori')->nullable();
            $table->string('kode_pelunasan')->nullable();
            $table->string('qrcode_pelunasan')->nullable();
            $table->string('kode_pelanggan')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('alamat_pelanggan')->nullable();
            $table->string('telp_pelanggan')->nullable();
            $table->string('saldo_masuk')->nullable();
            $table->string('potongan')->nullable();
            $table->string('kategoris')->nullable();
            $table->string('nomor')->nullable();
            $table->string('tanggal_transfer')->nullable();
            $table->string('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('potonganselisih')->nullable();
            $table->string('totalpenjualan')->nullable();
            $table->string('totalpembayaran')->nullable();
            $table->string('selisih')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_notif')->nullable();
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
        Schema::dropIfExists('faktur_pelunasans');
    }
};