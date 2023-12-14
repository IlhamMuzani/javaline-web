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
            $table->unsignedBigInteger('memotambahan_id')->nullable();
            $table->foreign('memotambahan_id')->references('id')->on('memo_ekspedisis');
            $table->string('kode_memo')->nullable();
            $table->string('kategori')->nullable();
            $table->string('qrcode_memo')->nullable();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->string('no_kabin')->nullable();
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