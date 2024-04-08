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
        Schema::create('detail_memos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memo_ekspedisi_id')->nullable();
            $table->foreign('memo_ekspedisi_id')->references('id')->on('memo_ekspedisis');
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
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->unsignedBigInteger('rute_id')->nullable();
            $table->foreign('rute_id')->references('id')->on('rute_perjalanans');
            $table->string('kode_rutes')->nullable();
            $table->string('nama_rutes')->nullable();
            $table->string('harga_rute')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('satuan')->nullable();
            $table->string('totalrute')->nullable();
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
        Schema::dropIfExists('detail_memos');
    }
};