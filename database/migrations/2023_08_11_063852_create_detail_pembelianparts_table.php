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
        Schema::create('detail_pembelianparts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_partdetail')->nullable();
            $table->string('kategori')->nullable();
            $table->string('qrcode_barang')->nullable();
            $table->unsignedBigInteger('pembelian_part_id')->nullable();
            $table->foreign('pembelian_part_id')->references('id')->on('pembelian_parts')->onDelete('set null');
            $table->unsignedBigInteger('sparepart_id')->nullable();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('set null');
            $table->string('nama_barang')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('satuan')->nullable();
            $table->string('harga')->nullable();
            $table->string('hargasatuan')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('detail_pembelianparts');
    }
};