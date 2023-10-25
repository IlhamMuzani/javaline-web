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
        Schema::create('laporanstnks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stnk_id')->nullable();
            $table->foreign('stnk_id')->references('id')->on('stnks')->onDelete('set null');
            $table->string('kode_perpanjangan')->nullable();
            $table->string('expired_stnk')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_stnk')->nullable();
            $table->string('status_notif')->nullable();
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
        Schema::dropIfExists('laporanstnks');
    }
};