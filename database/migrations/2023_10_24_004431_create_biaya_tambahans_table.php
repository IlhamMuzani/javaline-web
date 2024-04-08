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
        Schema::create('biaya_tambahans', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('biaya_tambahans');
    }
};