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
        Schema::create('penerimaan_kaskecils', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penerimaan')->nullable();
            $table->string('qr_code_penerimaan')->nullable();
            $table->unsignedBigInteger('saldo_id')->nullable();
            $table->foreign('saldo_id')->references('id')->on('saldos')->onDelete('set null');
            $table->unsignedBigInteger('deposit_driver_id')->nullable();
            $table->foreign('deposit_driver_id')->references('id')->on('deposit_drivers')->onDelete('set null');
            $table->string('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('saldo_masuk')->nullable();
            $table->string('sisa_saldo')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('jam')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tanggaljam')->nullable();
            $table->string('tanggal_awal')->nullable();
            $table->string('tanggal_akhir')->nullable();
            $table->string('status')->nullable();
            $table->string('status_notif')->nullable();
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
        Schema::dropIfExists('penerimaan_kaskecils');
    }
};