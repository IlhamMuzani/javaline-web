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
        Schema::create('detail_pemasanganparts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemasangan_part_id')->nullable();
            $table->foreign('pemasangan_part_id')->references('id')->on('pemasangan_parts')->onDelete('set null');
            $table->unsignedBigInteger('sparepart_id')->nullable();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('set null');
            $table->string('keterangan')->nullable();
            $table->string('jumlah')->nullable();
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
        Schema::dropIfExists('detail_pemasanganparts');
    }
};