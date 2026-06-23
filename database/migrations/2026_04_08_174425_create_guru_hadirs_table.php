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
        Schema::create('guru_hadir', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_piket');
            $table->foreignId('guru_id')->constrained('guru');
            $table->foreignId('mapel_id')->constrained('mapel');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->string('jam_ke', 10);
            $table->date('terlambat')->nullable();
            $table->string('status',20)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_hadir');
    }
};
