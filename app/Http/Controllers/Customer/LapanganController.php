<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\LapanganResource;
use App\Models\Lapangan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LapanganController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $lapangan = Lapangan::where('status', 'tersedia')->get();

        return LapanganResource::collection($lapangan);
    }

    public function show(int $id): LapanganResource|JsonResponse
    {
        $lapangan = Lapangan::find($id);

        if (! $lapangan || $lapangan->status !== 'tersedia') {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        return new LapanganResource($lapangan);
    }
}
