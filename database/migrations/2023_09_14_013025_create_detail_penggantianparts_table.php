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
        Schema::create('detail_penggantianparts', function (Blueprint $table) {
            $table->id();
            $table->string('kategori2')->nullable();
            $table->unsignedBigInteger('penggantians_oli_id')->nullable();
            $table->foreign('penggantians_oli_id')->references('id')->on('penggantian_olis')->onDelete('set null');
            $table->unsignedBigInteger('spareparts_id')->nullable();
            $table->foreign('spareparts_id')->references('id')->on('spareparts')->onDelete('set null');
            $table->string('km_penggantian2')->nullable();
            $table->string('km_berikutnya2')->nullable();
            $table->string('jumlah2')->nullable();
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
        Schema::dropIfExists('detail_penggantianparts');
    }
};