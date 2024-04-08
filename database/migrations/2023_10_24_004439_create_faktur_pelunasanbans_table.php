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
        Schema::create('faktur_pelunasanbans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->string('kode_pelunasanban')->nullable();
            $table->string('qrcode_pelunasanban')->nullable();
            $table->string('kode_supplier')->nullable();
            $table->string('nama_supplier')->nullable();
            $table->string('alamat_supplier')->nullable();
            $table->string('telp_supplier')->nullable();
            $table->string('potongan')->nullable();
            $table->string('tambahan_pembayaran')->nullable();
            $table->string('kategori')->nullable();
            $table->string('nomor')->nullable();
            $table->string('tanggal_transfer')->nullable();
            $table->string('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('potonganselisih')->nullable();
            $table->string('totalpenjualan')->nullable();
            $table->string('dp')->nullable();
            $table->string('totalpembayaran')->nullable();
            $table->string('selisih')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('faktur_pelunasanbans');
    }
};