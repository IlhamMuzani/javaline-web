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
        Schema::create('detail_tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tagihan_ekspedisi_id')->nullable();
            $table->foreign('tagihan_ekspedisi_id')->references('id')->on('tagihan_ekspedisis');
            $table->unsignedBigInteger('faktur_ekspedisi_id')->nullable();
            $table->foreign('faktur_ekspedisi_id')->references('id')->on('faktur_ekspedisis');
            $table->string('kode_faktur')->nullable();
            $table->string('nama_rute')->nullable();
            $table->string('no_memo')->nullable();
            $table->string('no_do')->nullable();
            $table->string('no_po')->nullable();
            $table->string('tanggal_memo')->nullable();
            $table->string('no_kabin')->nullable();
            $table->string('no_pol')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('satuan')->nullable();
            $table->string('harga')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('detail_tagihans');
    }
};