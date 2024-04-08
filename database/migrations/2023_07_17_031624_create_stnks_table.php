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
        Schema::create('stnks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_stnk')->unique();
            $table->string('qrcode_stnk')->nullable();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->unsignedBigInteger('jenis_kendaraan_id')->nullable();
            $table->foreign('jenis_kendaraan_id')->references('id')->on('jenis_kendaraans')->onDelete('set null');
            $table->string('nama_pemilik')->nullable();
            $table->string('alamat')->nullable();
            $table->string('merek')->nullable();
            $table->string('type')->nullable();
            $table->string('model')->nullable();
            $table->string('tahun_pembuatan')->nullable();
            $table->string('no_rangka')->nullable();
            $table->string('no_mesin')->nullable();
            $table->string('warna')->nullable();
            $table->string('warna_tnkb')->nullable();
            $table->string('tahun_registrasi')->nullable();
            $table->string('nomor_bpkb')->nullable();
            $table->string('expired_stnk')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status_stnk')->nullable();
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
        Schema::dropIfExists('stnks');
    }
};