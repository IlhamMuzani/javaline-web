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
        Schema::create('detail_penggantianolis', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->nullable();
            $table->unsignedBigInteger('penggantian_oli_id')->nullable();
            $table->foreign('penggantian_oli_id')->references('id')->on('penggantian_olis')->onDelete('set null');
            $table->unsignedBigInteger('sparepart_id')->nullable();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('set null');
            $table->string('km_penggantian')->nullable();
            $table->string('km_berikutnya')->nullable();
            $table->string('jumlah')->nullable();
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
        Schema::dropIfExists('detail_penggantianolis');
    }
};