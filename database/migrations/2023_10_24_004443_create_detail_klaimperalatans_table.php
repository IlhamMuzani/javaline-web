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
        Schema::create('detail_klaimperalatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klaim_peralatan_id')->nullable();
            $table->foreign('klaim_peralatan_id')->references('id')->on('klaim_peralatans')->onDelete('set null');
            $table->unsignedBigInteger('sparepart_id')->nullable();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('set null');
            $table->unsignedBigInteger('detail_inventory_id')->nullable();
            $table->foreign('detail_inventory_id')->references('id')->on('detail_inventories')->onDelete('set null');
            $table->string('kode_partdetail')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('harga')->nullable();
            $table->string('total')->nullable();
            $table->string('tanggal_awal')->nullable();
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
        Schema::dropIfExists('detail_klaimperalatans');
    }
};