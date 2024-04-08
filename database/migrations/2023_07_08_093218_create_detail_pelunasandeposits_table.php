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
        Schema::create('detail_pelunasandeposits', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->nullable();
            $table->unsignedBigInteger('pelunasan_deposit_id')->nullable();
            $table->foreign('pelunasan_deposit_id')->references('id')->on('pelunasan_deposits')->onDelete('set null');
            $table->unsignedBigInteger('detail_gajikaryawan_id')->nullable();
            $table->foreign('detail_gajikaryawan_id')->references('id')->on('detail_gajikaryawans')->onDelete('set null');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('set null');
            $table->string('kode_karyawan')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('kasbon_awal')->nullable();
            $table->string('pelunasan_kasbon')->nullable();
            $table->string('sisa_kasbon')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('detail_pelunasandeposits');
    }
};