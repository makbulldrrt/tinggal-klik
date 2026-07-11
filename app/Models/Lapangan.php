<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lapangan extends Model
{
    protected $table = 'lapangan';

    protected $fillable = [
        'nama_lapangan',
        'jenis_olahraga',
        'harga_per_jam',
        'deskripsi',
        'foto_lapangan',
        'status',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'lapangan_id');
    }
}
