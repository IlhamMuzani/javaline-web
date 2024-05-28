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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_karyawan')->unique();
            $table->unsignedBigInteger('departemen_id')->nullable();
            $table->foreign('departemen_id')->references('id')->on('departemens')->onDelete('set null');
            $table->string('qrcode_karyawan')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('no_sim')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('nama_kecil')->nullable();
            $table->string('gender')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('tanggal_gabung')->nullable();
            $table->string('tanggal_keluar')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('telp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('gambar')->nullable();
            $table->string('gaji')->nullable();
            $table->string('kasbon')->nullable();
            $table->string('deposit')->nullable();
            $table->string('bpjs')->nullable();
            $table->string('bayar_kasbon')->nullable();
            $table->string('tabungan')->nullable();
            $table->string('pembayaran')->nullable();
            $table->string('potongan_ke')->nullable();
            $table->string('kasbon_backup')->nullable();
            $table->string('potongan_backup')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('norek')->nullable();
            $table->string('status')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('karyawans');
    }
};
