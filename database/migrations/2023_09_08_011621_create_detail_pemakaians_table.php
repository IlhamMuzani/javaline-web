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
        Schema::create('detail_pemakaians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemakaian_peralatan_id')->nullable();
            $table->foreign('pemakaian_peralatan_id')->references('id')->on('pemakaian_peralatans')->onDelete('set null');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->unsignedBigInteger('sparepart_id')->nullable();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('set null');
            $table->string('keterangan')->nullable();
            $table->string('jumlah')->nullable();
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
        Schema::dropIfExists('detail_pemakaians');
    }
};