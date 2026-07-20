<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'lapangan_id');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'lapangan_id')->latest();
    }

    public function scopeJenisOlahraga(Builder $query, ?string $jenis): Builder
    {
        return $query->when(
            filled($jenis) && strtolower($jenis) !== 'semua',
            fn (Builder $q) => $q->whereRaw('LOWER(jenis_olahraga) = ?', [strtolower($jenis)])
        );
    }

    public function scopeSearchNama(Builder $query, ?string $keyword): Builder
    {
        return $query->when(
            filled($keyword),
            fn (Builder $q) => $q->where('nama_lapangan', 'like', '%' . $keyword . '%')
        );
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('status', 'tersedia');
    }
}
