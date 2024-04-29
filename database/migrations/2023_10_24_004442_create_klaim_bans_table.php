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
        Schema::create('klaim_bans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penerimaan_kaskecil_id')->nullable();
            $table->foreign('penerimaan_kaskecil_id')->references('id')->on('penerimaan_kaskecils')->onDelete('set null');
            $table->unsignedBigInteger('deposit_driver_id')->nullable();
            $table->foreign('deposit_driver_id')->references('id')->on('deposit_drivers')->onDelete('set null');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('set null');
            $table->unsignedBigInteger('ban_id')->nullable();
            $table->foreign('ban_id')->references('id')->on('bans')->onDelete('set null');
            $table->string('kode_klaimban')->nullable();
            $table->longText('keterangan')->nullable();
            $table->string('qr_codeklaim')->nullable();
            $table->string('harga_ban')->nullable();
            $table->string('sisa_harga')->nullable();
            $table->string('harga_klaim')->nullable();
            $table->string('km_terpakai')->nullable();
            $table->string('target_km')->nullable();
            $table->string('km_pemasangan')->nullable();
            $table->string('km_pelepasan')->nullable();
            $table->string('grand_total')->nullable();
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
        Schema::dropIfExists('klaim_bans');
    }
};