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
        Schema::create('nota_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans');
            $table->unsignedBigInteger('return_ekspedisi_id')->nullable();
            $table->foreign('return_ekspedisi_id')->references('id')->on('return_ekspedisis');
            $table->string('kode_return')->nullable();
            $table->string('admin')->nullable();
            $table->string('kode_nota')->nullable();
            $table->string('qrcode_nota')->nullable();
            $table->string('kode_pelanggan')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('alamat_pelanggan')->nullable();
            $table->string('telp_pelanggan')->nullable();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans');
            $table->string('no_kabin')->nullable();
            $table->string('no_pol')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('kode_driver')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('telp')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_return')->nullable();
            $table->string('status_notif')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    // Schema::create('return_ekspedisis', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('user_id')->nullable();
    //         $table->foreign('user_id')->references('id')->on('users');
    //         $table->unsignedBigInteger('pelanggan_id')->nullable();
    //         $table->foreign('pelanggan_id')->references('id')->on('pelanggans');
    //         $table->string('kode_return')->nullable();
    //         $table->string('qrcode_return')->nullable();
    //         $table->string('kode_pelanggan')->nullable();
    //         $table->string('nama_pelanggan')->nullable();
    //         $table->string('alamat_pelanggan')->nullable();
    //         $table->string('telp_pelanggan')->nullable();
    //         $table->string('nama_driver')->nullable();
    //         $table->string('no_kabin')->nullable();
    //         $table->string('keterangan')->nullable();
    //         $table->string('grand_total')->nullable();
    //         $table->string('tanggal')->nullable();
    //         $table->string('tanggal_awal')->nullable();
    //         $table->string('tanggal_akhir')->nullable();
    //         $table->string('status')->nullable();
    //         $table->string('status_notif')->nullable();

    //         $table->timestamps();
    //     });

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_returns');
    }
};