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
        Schema::create('laporanperjalanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kendaraan');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->string('no_kabin')->nullable();
            $table->string('no_pol')->nullable();
            $table->string('no_rangka')->nullable();
            $table->string('no_mesin')->nullable();
            $table->string('warna')->nullable();
            $table->string('expired_kir')->nullable();
            $table->string('expired_stnk')->nullable();
            $table->unsignedBigInteger('jenis_kendaraan_id')->nullable();
            $table->foreign('jenis_kendaraan_id')->references('id')->on('jenis_kendaraans')->onDelete('set null');
            $table->unsignedBigInteger('golongan_id')->nullable();
            $table->unsignedBigInteger('kota_id')->nullable();
            $table->foreign('kota_id')->references('id')->on('kotas')->onDelete('set null');
            $table->foreign('golongan_id')->references('id')->on('golongans')->onDelete('set null');
            $table->unsignedBigInteger('divisi_id')->nullable();
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('set null');
            $table->string('km')->nullable()->nullable();
            $table->string('km_olimesin')->nullable()->nullable();
            $table->string('km_oligardan')->nullable()->nullable();
            $table->string('km_olitransmisi')->nullable()->nullable();
            $table->string('status')->nullable();
            $table->string('qrcode_kendaraan')->nullable();
            $table->string('status_pemasangan')->nullable();
            $table->string('kode_pemasangan')->nullable();
            $table->string('kode_pelepasan')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('tanggal_awalperjalanan')->nullable();
            $table->string('tanggal_akhirperjalanan')->nullable();
            $table->string('status_post')->nullable();
            $table->string('status_notif')->nullable();
            $table->string('status_notifkm')->nullable();
            $table->string('status_olimesin')->nullable();
            $table->string('status_oligardan')->nullable();
            $table->string('status_olitransmisi')->nullable();
            $table->string('status_perjalanan')->nullable();
            $table->string('timer')->nullable();
            $table->string('tujuan')->nullable();
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
        Schema::dropIfExists('laporanperjalanans');
    }
};