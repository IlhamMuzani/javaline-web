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
        Schema::create('detail_pelunasans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_pelunasan_id')->nullable();
            $table->foreign('faktur_pelunasan_id')->references('id')->on('faktur_pelunasans');
            $table->unsignedBigInteger('faktur_ekspedisi_id')->nullable();
            $table->foreign('faktur_ekspedisi_id')->references('id')->on('faktur_ekspedisis');
            $table->string('kode_faktur')->nullable();
            $table->string('tanggal_faktur')->nullable();
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
        Schema::dropIfExists('detail_pelunasans');
    }
};
