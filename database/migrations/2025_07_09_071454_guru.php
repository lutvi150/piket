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
        Schema::create("guru", function (Blueprint $table) {
            $table->id();
            $table->integer("id_user")->unique();
            $table->string("nama_guru");
            $table->string("nip")->unique();
            $table->enum("jenis_kelamin", ["L", "P"])->default("L");
            $table->string("golongan");
            $table->string("jabatan")->nullable();
            $table->text("foto")->nullable();
            $table->text('alamat');
            $table->string("no_hp", 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("guru");
    }
};
