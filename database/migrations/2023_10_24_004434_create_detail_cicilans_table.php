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
        Schema::create('detail_cicilans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kasbon_karyawan_id')->nullable();
            $table->foreign('kasbon_karyawan_id')->references('id')->on('kasbon_karyawans');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans');
            $table->string('nominal_cicilan')->nullable();
            $table->string('status')->nullable();
            $table->string('status_cicilan')->nullable();
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
        Schema::dropIfExists('detail_cicilans');
    }
};