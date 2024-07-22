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
        Schema::create('detail_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemakaian_peralatan_id')->nullable();
            $table->foreign('pemakaian_peralatan_id')->references('id')->on('pemakaian_peralatans')->onDelete('set null');
            $table->unsignedBigInteger('detail_pemakaian_id')->nullable();
            $table->foreign('detail_pemakaian_id')->references('id')->on('detail_pemakaians')->onDelete('set null');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->unsignedBigInteger('sparepart_id')->nullable();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('set null');
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('harga')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('detail_inventories');
    }
};