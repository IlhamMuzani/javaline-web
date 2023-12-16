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
        Schema::create('faktur_ekspedisis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans');
            $table->unsignedBigInteger('tarif_id')->nullable();
            $table->foreign('tarif_id')->references('id')->on('tarifs');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans');
            $table->string('no_kabin')->nullable();
            $table->string('pph')->nullable();
            $table->string('kode_faktur')->nullable();
            $table->string('kategori')->nullable();
            $table->string('qrcode_faktur')->nullable();
            $table->string('kode_pelanggan')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('alamat_pelanggan')->nullable();
            $table->string('telp_pelanggan')->nullable();
            $table->string('kode_tarif')->nullable();
            $table->string('nama_tarif')->nullable();
            $table->string('harga_tarif')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('satuan')->nullable();
            $table->string('total_tarif')->nullable();
            $table->string('total_tarif2')->nullable();
            $table->string('sisa')->nullable();
            $table->string('biaya_tambahan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_notif')->nullable();

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
        Schema::dropIfExists('memo_ekspedisis');
    }
};