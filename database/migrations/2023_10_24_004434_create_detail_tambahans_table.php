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
        Schema::create('detail_tambahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memo_ekspedisi_id')->nullable();
            $table->foreign('memo_ekspedisi_id')->references('id')->on('memo_ekspedisis');
            $table->unsignedBigInteger('biaya_tambahan_id')->nullable();
            $table->foreign('biaya_tambahan_id')->references('id')->on('biaya_tambahans');
            $table->string('kode_biaya')->nullable();
            $table->string('nama_biaya')->nullable();
            $table->string('nominal')->nullable();
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
        Schema::dropIfExists('detail_tambahans');
    }
};