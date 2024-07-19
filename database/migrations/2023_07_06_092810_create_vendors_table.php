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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('kode_vendor')->nullable();
            $table->string('nama_vendor')->nullable();
            $table->string('nama_alias')->nullable();
            $table->string('qrcode_vendor')->nullable();
            $table->string('alamat')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nama_person')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('telp')->nullable();
            $table->string('fax')->nullable();
            $table->string('hp')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('vendors');
    }
};