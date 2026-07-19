<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\JsonResponse;

class LapanganController extends Controller
{
    public function index(): JsonResponse
    {
        $lapangan = Lapangan::where('status', true)->with('owner:id,name')->get();

        return response()->json($lapangan);
    }

    public function show(int $id): JsonResponse
    {
        $lapangan = Lapangan::with('owner:id,name')->find($id);

        if (! $lapangan || ! $lapangan->status) {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        return response()->json($lapangan);
    }
}
