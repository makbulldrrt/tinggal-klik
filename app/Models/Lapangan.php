<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Lapangan
 *
 * Represents a sports court (lapangan) owned by a vendor (User with role=owner).
 *
 * @property int         $id
 * @property int|null    $user_id         FK → users.id (the owner/vendor)
 * @property string      $nama_lapangan
 * @property string      $jenis_olahraga  e.g. Futsal, Badminton, Basket, Tennis, Voli
 * @property int         $harga_per_jam   Price in IDR per hour (integer, no decimals)
 * @property string      $deskripsi
 * @property string|null $foto_lapangan   Relative path stored in public/storage
 * @property string|null $lokasi          Human-readable location shown on the catalog card
 * @property string      $status          ENUM: tersedia | pemeliharaan
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * --- Relationships ---
 * @property-read User|null   $owner     The vendor who owns this court
 * @property-read Booking[]   $bookings  All bookings for this court
 */
class Lapangan extends Model
{
    protected $table = 'lapangan';

    protected $fillable = [
        'user_id',
        'nama_lapangan',
        'jenis_olahraga',
        'harga_per_jam',
        'deskripsi',
        'foto_lapangan',
        'lokasi',
        'status',
    ];

    protected $casts = [
        'harga_per_jam' => 'integer',
    ];

    // ──────────────────────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * The vendor (User with role=owner) who registered this court.
     *
     * Used in the blade via: $court->owner->name
     * The blade also checks $court->owner->nama_bisnis — add that column to
     * users once Rehan's auth module creates the owner profile table.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * All booking records associated with this court.
     * Managed by Decky (Modul 3).
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'lapangan_id');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // LOCAL QUERY SCOPES
    //
    // Encapsulate filter logic here so both the catalog controller and any
    // future API controller can reuse without duplication.
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Scope: filter by sport type (case-insensitive).
     *
     * Usage: Lapangan::query()->jenisOlahraga('futsal')
     */
    public function scopeJenisOlahraga(Builder $query, ?string $jenis): Builder
    {
        return $query->when(
            filled($jenis) && strtolower($jenis) !== 'semua',
            fn (Builder $q) => $q->whereRaw('LOWER(jenis_olahraga) = ?', [strtolower($jenis)])
        );
    }

    /**
     * Scope: full-text name search (case-insensitive LIKE).
     *
     * Usage: Lapangan::query()->searchNama('merdeka')
     */
    public function scopeSearchNama(Builder $query, ?string $keyword): Builder
    {
        return $query->when(
            filled($keyword),
            fn (Builder $q) => $q->where('nama_lapangan', 'like', '%' . $keyword . '%')
        );
    }

    /**
     * Scope: only courts currently available for booking.
     */
    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('status', 'tersedia');
    }
}
