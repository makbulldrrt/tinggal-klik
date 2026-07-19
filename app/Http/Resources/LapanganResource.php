<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LapanganResource extends JsonResource
{
    public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'owner_id'     => $this->user_id,
            'nama'         => $this->nama_lapangan,
            'jenis'        => $this->jenis_olahraga,
            'harga_per_jam'=> (int) $this->harga_per_jam,
            'deskripsi'    => $this->deskripsi,
            'status'       => $this->status === 'tersedia',
            'lokasi'       => $this->lokasi,
            'foto_lapangan'=> $this->foto_lapangan,
        ];
    }
}
