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
        Schema::create('detail_potongans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memo_ekspedisi_id')->nullable();
            $table->foreign('memo_ekspedisi_id')->references('id')->on('memo_ekspedisis');
            $table->unsignedBigInteger('potongan_memo_id')->nullable();
            $table->foreign('potongan_memo_id')->references('id')->on('potongan_memos');
            $table->string('kode_potongan')->nullable();
            $table->string('keterangan_potongan')->nullable();
            $table->string('nominal_potongan')->nullable();
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
        Schema::dropIfExists('detail_memotambahans');
    }
};