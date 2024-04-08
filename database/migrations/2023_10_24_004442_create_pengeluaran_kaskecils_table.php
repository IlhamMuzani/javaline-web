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
        Schema::create('pengeluaran_kaskecils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->unsignedBigInteger('memo_ekspedisi_id')->nullable();
            $table->foreign('memo_ekspedisi_id')->references('id')->on('memo_ekspedisis')->onDelete('set null');
            $table->unsignedBigInteger('memotambahan_id')->nullable();
            $table->foreign('memotambahan_id')->references('id')->on('memotambahans')->onDelete('set null');
            $table->unsignedBigInteger('laporankir_id')->nullable();
            $table->foreign('laporankir_id')->references('id')->on('laporankirs')->onDelete('set null');
            $table->unsignedBigInteger('laporanstnk_id')->nullable();
            $table->foreign('laporanstnk_id')->references('id')->on('laporanstnks')->onDelete('set null');
            $table->unsignedBigInteger('perhitungan_gajikaryawan_id')->nullable();
            $table->foreign('perhitungan_gajikaryawan_id')->references('id')->on('perhitungan_gajikaryawans')->onDelete('set null');
            $table->unsignedBigInteger('kasbon_karyawan_id')->nullable();
            $table->foreign('kasbon_karyawan_id')->references('id')->on('kasbon_karyawans')->onDelete('set null');
            $table->string('kode_pengeluaran')->nullable();
            $table->longText('keterangan')->nullable();
            $table->string('qrcode_pengeluaran')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('jam')->nullable();
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
        Schema::dropIfExists('pengeluaran_kaskecils');
    }
};