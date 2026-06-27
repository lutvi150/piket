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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa',100);
            $table->string('nisn',15)->unique();
            $table->string('nik', 16)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('tingkat_rombel');
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
            $table->integer('id_kelas');
            $table->text('foto')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
