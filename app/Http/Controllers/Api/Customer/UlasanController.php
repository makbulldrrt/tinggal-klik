<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Ulasan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer'],
            'lapang_id'  => ['required', 'integer', 'exists:lapangan,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'ulasan'     => ['required', 'string'],
        ]);

        $pemesanan = Pemesanan::where('id', $validated['booking_id'])
            ->where('user_id', auth()->id())
            ->where('status_pembayaran', 'lunas')
            ->first();

        if (! $pemesanan) {
            return response()->json(['message' => 'Data booking tidak valid atau belum lunas.'], 400);
        }

        $ulasan = Ulasan::create([
            'user_id'     => auth()->id(),
            'lapangan_id' => $validated['lapang_id'],
            'pemesanan_id'=> $validated['booking_id'],
            'rating'      => $validated['rating'],
            'komentar'    => $validated['ulasan'],
        ]);

        return response()->json($ulasan, 201);
    }
}
