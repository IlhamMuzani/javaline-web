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
        Schema::create('detail_memotambahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memotambahan_id')->nullable();
            $table->foreign('memotambahan_id')->references('id')->on('memotambahans');
            $table->string('kode_tambahan')->nullable();
            $table->string('keterangan_tambahan')->nullable();
            $table->string('qty')->nullable();
            $table->string('satuans')->nullable();
            $table->string('hargasatuan')->nullable();
            $table->string('nominal_tambahan')->nullable();
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