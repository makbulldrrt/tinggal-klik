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
       Schema::create('lapangan', function (Blueprint $table) {
        $table->id(); // bigint, PK
        $table->string('nama_lapangan');
        $table->string('jenis_olahraga'); // Menyesuaikan ERD Rehan
        $table->integer('harga_per_jam');
        $table->text('deskripsi');
        $table->string('foto_lapangan')->nullable(); // nullable agar tidak error jika belum upload foto
        $table->enum('status', ['tersedia', 'pemeliharaan'])->default('tersedia');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};
