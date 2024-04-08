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
        Schema::create('pengeluaran_ujs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('total_ujs_id')->nullable();
            $table->foreign('total_ujs_id')->references('id')->on('total_ujs')->onDelete('set null');
            $table->string('kode_pengambilanujs')->nullable();
            $table->longText('keterangan')->nullable();
            $table->string('qr_code_pengeluran')->nullable();
            $table->string('saldo_masuk')->nullable();
            $table->string('sisa_ujs')->nullable();
            $table->longText('nominal')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('tanggaljam')->nullable();
            $table->string('jam')->nullable();
            $table->string('tanggal')->nullable();
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
        Schema::dropIfExists('pengeluaran_kaskecils');
    }
};