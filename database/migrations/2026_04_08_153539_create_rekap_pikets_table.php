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
    Schema::create('rekap_piket', function (Blueprint $table) {
            $table->id();
            $table->date("tanggal");
            $table->foreignId('kelas_id')->nullable()->constrained('kelas');
            $table->foreignId('mapel_id')->nullable()->constrained('mapel');
            $table->morphs('piket');
            $table->unsignedInteger('terlambat')->default(0);
            $table->enum("status", ["S", "I", "A"]);
            $table->text('keterangan')->nullable();
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_piket');
    }
};
