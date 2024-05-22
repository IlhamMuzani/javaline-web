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
        Schema::create('km_bans', function (Blueprint $table) {
            $table->id();
            $table->string('umur_ban')->nullable();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->unsignedBigInteger('ban_id')->nullable();
            $table->foreign('ban_id')->references('id')->on('bans')->onDelete('set null');
            $table->unsignedBigInteger('pemasangan_ban_id')->nullable();
            $table->foreign('pemasangan_ban_id')->references('id')->on('pemasangan_bans')->onDelete('set null');
            $table->unsignedBigInteger('pelepasan_ban_id')->nullable();
            $table->foreign('pelepasan_ban_id')->references('id')->on('pelepasan_bans')->onDelete('set null');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('km_bans');
    }
};