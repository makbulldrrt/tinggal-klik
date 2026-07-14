<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Update lapangan table
 *
 * Adds three things required by the catalog controller & blueprint:
 *   1. user_id  — FK to users (the owner/vendor) so Eager Loading works.
 *   2. lokasi   — Human-readable location string shown on the card.
 *   3. Indexes  — on jenis_olahraga & status for fast filter queries
 *                 (STARTUP_BLUEPRINT.md §4, rule 1).
 *
 * PJ: Backend (your module) | Depends on: create_lapangan_table migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lapangan', function (Blueprint $table) {

            // ── 1. Owner FK ──────────────────────────────────────────────────
            // unsignedBigInteger to match users.id type; nullable so existing
            // rows don't violate the constraint before a seeder runs.
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();   // Keep the court if owner account is deleted

            // ── 2. Lokasi column ─────────────────────────────────────────────
            // The blade reads $court->lokasi and falls back to owner->nama_bisnis.
            // Storing it here avoids a JOIN for every card render.
            $table->string('lokasi')->nullable()->after('foto_lapangan');

            // ── 3. Performance indexes ───────────────────────────────────────
            // Blueprint §4 rule 1: index columns used in WHERE clauses.
            $table->index('jenis_olahraga', 'idx_lapangan_jenis_olahraga');
            $table->index('status',         'idx_lapangan_status');
            $table->index('user_id',        'idx_lapangan_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('lapangan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex('idx_lapangan_jenis_olahraga');
            $table->dropIndex('idx_lapangan_status');
            $table->dropIndex('idx_lapangan_user_id');
            $table->dropColumn(['user_id', 'lokasi']);
        });
    }
};
