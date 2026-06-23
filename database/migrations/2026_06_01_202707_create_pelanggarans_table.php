<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->string('jenis_pelanggaran');
            $table->date('tanggal_pelanggaran');
            $table->integer('poin');
            $table->string('tindakan_sanksi')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
