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
        Schema::create('pengambilan_dos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('spk_id')->nullable();
            $table->foreign('spk_id')->references('id')->on('spks');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans');
            $table->unsignedBigInteger('rute_perjalanan_id')->nullable();
            $table->foreign('rute_perjalanan_id')->references('id')->on('rute_perjalanans');
            $table->unsignedBigInteger('alamat_muat_id')->nullable();
            $table->foreign('alamat_muat_id')->references('id')->on('alamat_muats');
            $table->unsignedBigInteger('alamat_bongkar_id')->nullable();
            $table->foreign('alamat_bongkar_id')->references('id')->on('alamat_bongkars');
            $table->string('kode_pengambilan')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('pengambilan_dos');
    }
};