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
        Schema::create('detail_pelunasanbans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_pelunasanban_id')->nullable();
            $table->foreign('faktur_pelunasanban_id')->references('id')->on('faktur_pelunasanbans');
            $table->unsignedBigInteger('pembelian_ban_id')->nullable();
            $table->foreign('pembelian_ban_id')->references('id')->on('pembelian_bans');
            $table->string('kode_pembelian_ban')->nullable();
            $table->string('tanggal_pembelian')->nullable();
            $table->string('total')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('detail_pelunasanbans');
    }
};