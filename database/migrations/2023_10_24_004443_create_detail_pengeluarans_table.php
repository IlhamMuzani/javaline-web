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
        Schema::create('detail_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengeluaran_kaskecil_id')->nullable();
            $table->foreign('pengeluaran_kaskecil_id')->references('id')->on('pengeluaran_kaskecils');
            $table->unsignedBigInteger('memo_ekspedisi_id')->nullable();
            $table->foreign('memo_ekspedisi_id')->references('id')->on('memo_ekspedisis');
            $table->unsignedBigInteger('memotambahan_id')->nullable();
            $table->foreign('memotambahan_id')->references('id')->on('memotambahans');
            $table->unsignedBigInteger('detail_memotambahan_id')->nullable();
            $table->foreign('detail_memotambahan_id')->references('id')->on('detail_memotambahans');
            $table->unsignedBigInteger('laporankir_id')->nullable();
            $table->foreign('laporankir_id')->references('id')->on('laporankirs');
            $table->unsignedBigInteger('laporanstnk_id')->nullable();
            $table->foreign('laporanstnk_id')->references('id')->on('laporanstnks');
            $table->unsignedBigInteger('perhitungan_gajikaryawan_id')->nullable();
            $table->foreign('perhitungan_gajikaryawan_id')->references('id')->on('perhitungan_gajikaryawans')->onDelete('set null');
            $table->unsignedBigInteger('kasbon_karyawan_id')->nullable();
            $table->foreign('kasbon_karyawan_id')->references('id')->on('kasbon_karyawans')->onDelete('set null');
            $table->unsignedBigInteger('barangakun_id')->nullable();
            $table->foreign('barangakun_id')->references('id')->on('barang_akuns');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans');
            $table->string('kode_detailakun')->nullable();
            $table->string('kode_akun')->nullable();
            $table->string('nama_akun')->nullable();
            $table->string('nominal')->nullable();
            $table->longText('keterangan')->nullable();
            $table->string('qty')->nullable();
            $table->string('satuans')->nullable();
            $table->string('hargasatuan')->nullable();
            $table->string('status')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->timestamp('deleted_at')->nullable(); // Menambahkan kembali kolom dengan tipe data timest            $table->timestamps();
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
        Schema::dropIfExists('detail_pengeluarans');
    }
};