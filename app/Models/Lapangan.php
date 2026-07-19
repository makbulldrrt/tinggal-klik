<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lapangan extends Model
{
    protected $table = 'lapangans';

    protected $fillable = [
        'owner_id',
        'nama',
        'jenis',
        'harga_per_jam',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'harga_per_jam' => 'integer',
        'status'        => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
