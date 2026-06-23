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
        Schema::create('rekap_guru', function (Blueprint $table) {
            $table->id();
            $table->integer('id_guru');
            $table->integer('id_mapel');
            $table->integer('id_kelas');
            $table->string('status');
            $table->date('tanggal');
            $table->time('jam_hadir');
            $table->text('keterangan')->nullable();
            $table->text('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_guru');
    }
};
