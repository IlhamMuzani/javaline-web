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
        Schema::create('pelepasan_bans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            // $table->unsignedBigInteger('pemasangan_ban_id')->nullable();
            // $table->foreign('pemasangan_ban_id')->references('id')->on('pemasangan_bans');
            $table->string('kode_pelepasan')->nullable();
            $table->timestamps();
            $table->string('status')->nullable();
            $table->string('status_notif')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelepasan_bans');
    }
};