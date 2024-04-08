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
        Schema::create('detail_pembelianbans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bandetail')->nullable();
            $table->unsignedBigInteger('pembelian_ban_id')->nullable();
            $table->foreign('pembelian_ban_id')->references('id')->on('pembelian_bans');
            $table->unsignedBigInteger('merek_id')->nullable();
            $table->foreign('merek_id')->references('id')->on('mereks');
            $table->unsignedBigInteger('ukuran_id')->nullable();
            $table->foreign('ukuran_id')->references('id')->on('ukurans');
            $table->string('no_seri')->nullable();
            $table->string('kondisi_ban')->nullable();
            $table->string('harga')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('detail_pembelianbans');
    }
};