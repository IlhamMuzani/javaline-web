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
        Schema::create('deposit_drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans');
            $table->unsignedBigInteger('memo_ekspedisi_id')->nullable();
            $table->foreign('memo_ekspedisi_id')->references('id')->on('memo_ekspedisis');
            $table->string('kategori')->nullable();
            $table->string('kode_deposit')->nullable();
            $table->string('kode_sopir')->nullable();
            $table->string('nama_sopir')->nullable();
            $table->string('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('saldo_masuk')->nullable();
            $table->string('saldo_keluar')->nullable();
            $table->string('sisa_saldo')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('status')->nullable();
            $table->string('status_notif')->nullable();
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
        Schema::dropIfExists('deposit_drivers');
    }
};