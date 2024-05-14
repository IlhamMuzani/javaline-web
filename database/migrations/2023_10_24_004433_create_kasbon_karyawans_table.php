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
        Schema::create('kasbon_karyawans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans');
            $table->string('kategori')->nullable();
            $table->string('kode_kasbon')->nullable();
            $table->string('kode_karyawan')->nullable();
            $table->string('nama_karyawan')->nullable();
            $table->string('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('saldo_masuk')->nullable();
            $table->string('saldo_keluar')->nullable();
            $table->string('sisa_saldo')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('nominal_cicilan')->nullable();
            $table->string('nominal_lebih')->nullable();
            $table->string('jumlah_cicilan')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('status')->nullable();
            $table->string('status_notif')->nullable();
            $table->string('tanggal')->nullable();
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
        Schema::dropIfExists('kasbon_karyawans');
    }
};