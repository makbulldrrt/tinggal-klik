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
        Schema::create('pemesanan', function (Blueprint $table) {
        $table->id(); // bigint, PK
        
        // Foreign Key ke tabel users dan lapangan
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('lapangan_id')->constrained('lapangan')->onDelete('cascade');
        
        $table->date('tanggal_pesan');
        $table->time('jam_mulai');
        $table->time('jam_selesai');
        $table->unsignedTinyInteger('total_durasi'); // tinyint sesuai ERD Rehan
        $table->integer('total_harga');
        $table->enum('status_pembayaran', ['belum_bayar', 'lunas', 'batal'])->default('belum_bayar');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
