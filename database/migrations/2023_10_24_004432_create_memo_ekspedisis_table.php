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
        Schema::create('memo_ekspedisis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_memo')->nullable();
            $table->string('kategori')->nullable();
            $table->string('admin')->nullable();
            $table->string('qrcode_memo')->nullable();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->string('no_kabin')->nullable();
            $table->string('no_pol')->nullable();
            $table->string('golongan')->nullable();
            $table->string('km_awal')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('kode_driver')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('telp')->nullable();
            $table->string('saldo_deposit')->nullable();
            $table->unsignedBigInteger('rute_perjalanan_id')->nullable();
            $table->foreign('rute_perjalanan_id')->references('id')->on('rute_perjalanans')->onDelete('set null');
            $table->string('kode_rute')->nullable();
            $table->string('nama_rute')->nullable();
            $table->string('uang_jalan')->nullable();
            $table->string('uang_jalans')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('harga_rute')->nullable();
            $table->string('satuan')->nullable();
            $table->string('totalrute')->nullable();
            $table->string('hasil_jumlah')->nullable();
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->string('uang_jaminan')->nullable();
            $table->string('biaya_tambahan')->nullable();
            $table->string('potongan_memo')->nullable();
            $table->string('kode_pelanggan')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('alamat_pelanggan')->nullable();
            $table->string('telp_pelanggan')->nullable();
            $table->string('deposit_driver')->nullable();
            $table->string('pphs')->nullable();
            $table->string('total_borongs')->nullable();
            $table->string('uang_jaminans')->nullable();
            $table->string('deposit_drivers')->nullable();
            $table->string('totals')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('sisa_saldo')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_memo')->nullable();
            $table->string('status_notif')->nullable();
            $table->string('status_terpakai')->nullable();
            $table->unsignedBigInteger('biaya_id')->nullable();
            $table->foreign('biaya_id')->references('id')->on('biaya_tambahans');
            $table->string('kode_biaya')->nullable();
            $table->string('nama_biaya')->nullable();
            $table->string('nominal')->nullable();
            $table->unsignedBigInteger('potongan_id')->nullable();
            $table->foreign('potongan_id')->references('id')->on('potongan_memos');
            $table->string('kode_potongan')->nullable();
            $table->string('keterangan_potongan')->nullable();
            $table->string('nominal_potongan')->nullable();
            $table->unsignedBigInteger('rute_id')->nullable();
            $table->foreign('rute_id')->references('id')->on('rute_perjalanans');
            $table->string('kode_rutes')->nullable();
            $table->string('nama_rutes')->nullable();
            $table->timestamp('deleted_at')->nullable();
            // $table->string('harga_rute')->nullable();
            // $table->string('jumlah')->nullable();
            // $table->string('satuan')->nullable();
            // $table->string('totalrute')->nullable();

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