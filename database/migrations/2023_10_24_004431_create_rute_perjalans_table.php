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
        Schema::create('rute_perjalanans', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi')->nullable();
            $table->string('qrcode_rute')->nullable();
            $table->string('kode_rute')->nullable();
            $table->string('nama_rute')->nullable();
            $table->string('golongan1')->nullable();
            $table->string('golongan2')->nullable();
            $table->string('golongan3')->nullable();
            $table->string('golongan4')->nullable();
            $table->string('golongan5')->nullable();
            $table->string('golongan6')->nullable();
            $table->string('golongan7')->nullable();
            $table->string('golongan8')->nullable();
            $table->string('golongan9')->nullable();
            $table->string('golongan10')->nullable();
            $table->string('kategori')->nullable();
            $table->string('harga')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('rute_perjalanans');
    }
};