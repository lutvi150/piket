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
        Schema::create("kelas", function (Blueprint $table) {
            $table->id();
            $table->string("nama_kelas",15)->unique();
            $table->unsignedBigInteger("id_guru")->nullable();
            $table->foreign("id_guru")->references("id")->on("guru")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("kelas");
    }
};
