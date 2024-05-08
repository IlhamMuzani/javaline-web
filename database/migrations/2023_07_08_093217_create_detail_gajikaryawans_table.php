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
        Schema::create('detail_gajikaryawans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gajikaryawan')->nullable();
            $table->string('kategori')->nullable();
            $table->unsignedBigInteger('perhitungan_gajikaryawan_id')->nullable();
            $table->foreign('perhitungan_gajikaryawan_id')->references('id')->on('perhitungan_gajikaryawans')->onDelete('set null');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('set null');
            $table->string('kode_karyawan')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('gaji')->nullable();
            $table->string('gaji_perhari')->nullable();
            $table->string('tdk_berangkat')->nullable();
            $table->string('hasiltdk_berangkat')->nullable();
            $table->string('tgl_merah')->nullable();
            $table->string('hasiltgl_merah')->nullable();
            $table->string('hari_efektif')->nullable();
            $table->string('hasil_hk')->nullable();
            $table->string('uang_makan')->nullable();
            $table->string('uang_hadir')->nullable();
            $table->string('hari_kerja')->nullable();
            $table->string('lembur')->nullable();
            $table->string('hasil_lembur')->nullable();
            $table->string('storing')->nullable();
            $table->string('hasil_storing')->nullable();
            $table->string('gaji_kotor')->nullable();
            $table->string('kurangtigapuluh')->nullable();
            $table->string('lebihtigapuluh')->nullable();
            $table->string('hasilkurang')->nullable();
            $table->string('hasillebih')->nullable();
            $table->string('absen')->nullable();
            $table->string('potongan_bpjs')->nullable();
            $table->string('lainya')->nullable();
            $table->string('pelunasan_kasbon')->nullable();
            $table->string('hasil_absen')->nullable();
            $table->string('gaji_bersih')->nullable();
            $table->string('gajinol_pelunasan')->nullable();
            $table->string('potongan_ke')->nullable();
            $table->string('kasbon_awal')->nullable();
            $table->string('sisa_kasbon')->nullable();
            $table->string('status')->nullable();
            $table->string('tanggal')->nullable();
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
        Schema::dropIfExists('detail_gajikaryawans');
    }
};