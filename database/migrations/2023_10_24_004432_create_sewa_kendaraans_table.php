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
        Schema::create('sewa_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sewa')->nullable();
            $table->string('kategori')->nullable();
            $table->string('admin')->nullable();
            $table->string('qrcode_sewa')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('set null');
            $table->unsignedBigInteger('rute_perjalanan_id')->nullable();
            $table->foreign('rute_perjalanan_id')->references('id')->on('rute_perjalanans')->onDelete('set null');
            $table->string('no_pol')->nullable();
            $table->string('nama_driver')->nullable();
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
        Schema::dropIfExists('memo_ekspedisis');
    }
};