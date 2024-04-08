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
        Schema::create('memotambahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memo_ekspedisi_id')->nullable();
            $table->foreign('memo_ekspedisi_id')->references('id')->on('memo_ekspedisis');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans');
            $table->string('admin')->nullable();
            $table->string('kode_tambahan')->nullable();
            $table->string('kategori')->nullable();
            $table->string('no_memo')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('telp')->nullable();
            $table->string('no_kabin')->nullable();
            $table->string('no_pol')->nullable();
            $table->string('nama_rute')->nullable();
            $table->string('status')->nullable();
            $table->string('status_memo')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('tanggal')->nullable();
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
        Schema::dropIfExists('memotambahans');
    }
};