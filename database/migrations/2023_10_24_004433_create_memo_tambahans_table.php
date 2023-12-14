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
        Schema::create('memotambahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memo_id')->nullable();
            $table->foreign('memo_id')->references('id')->on('memo_ekspedisis');
            $table->string('kode_tambahan')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('tanggal_awal')->nullable();
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
        Schema::dropIfExists('memotambahans');
    }
};