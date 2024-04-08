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
        Schema::create('detail_pelunasanparts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_pelunasanpart_id')->nullable();
            $table->foreign('faktur_pelunasanpart_id')->references('id')->on('faktur_pelunasanparts');
            $table->unsignedBigInteger('pembelian_part_id')->nullable();
            $table->foreign('pembelian_part_id')->references('id')->on('pembelian_parts');
            $table->string('kode_pembelianpart')->nullable();
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
        Schema::dropIfExists('detail_pelunasanparts');
    }
};