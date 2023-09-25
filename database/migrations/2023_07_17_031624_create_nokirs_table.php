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
        Schema::create('nokirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->string('kode_kir')->unique();
            $table->string('qrcode_kir')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomor_uji_kendaraan')->nullable();
            $table->string('nomor_sertifikat_kendaraan')->nullable();
            $table->string('tanggal_sertifikat')->nullable();
            $table->string('nopol')->nullable();
            $table->string('no_rangka')->nullable();
            $table->string('no_mesin')->nullable();
            $table->string('gambar_depan')->nullable();
            $table->string('gambar_belakang')->nullable();
            $table->string('gambar_kanan')->nullable();
            $table->string('gambar_kiri')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('merek_kendaraan')->nullable();
            $table->string('tahun_kendaraan')->nullable();
            $table->string('bahan_bakar')->nullable();
            $table->string('isi_silinder')->nullable();
            $table->string('daya_motor')->nullable();
            $table->string('ukuran_ban')->nullable();
            $table->string('konfigurasi_sumbu')->nullable();
            $table->string('berat_kosongkendaraan')->nullable();
            $table->string('panjang')->nullable();
            $table->string('lebar')->nullable();
            $table->string('tinggi')->nullable();
            $table->string('julur_depan')->nullable();
            $table->string('julur_belakang')->nullable();
            $table->string('sumbu_1_2')->nullable();
            $table->string('sumbu_2_3')->nullable();
            $table->string('sumbu_3_4')->nullable();
            $table->string('dimensi_bakmuatan')->nullable();
            $table->string('jbb')->nullable();
            $table->string('jbi')->nullable();
            $table->string('daya_angkutorang')->nullable();
            $table->string('kelas_jalan')->nullable();
            $table->string('rem_utama')->nullable();
            $table->string('lampu_utama')->nullable();
            $table->string('emisi')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('masa_berlaku')->nullable();
            $table->string('nama_petugas_penguji')->nullable();
            $table->string('nrp_petugas_penguji')->nullable();
            $table->string('nama_kepala_dinas')->nullable();
            $table->string('pangkat_kepala_dinas')->nullable();
            $table->string('nip_kepala_dinas')->nullable();
            $table->string('unit_pelaksanaan_teknis')->nullable();
            $table->string('nama_direktur')->nullable();
            $table->string('pangkat_direktur')->nullable();
            $table->string('nip_direktur')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('status_kir')->nullable();
            $table->string('status_notif')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
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
        Schema::dropIfExists('nokirs');
    }
};