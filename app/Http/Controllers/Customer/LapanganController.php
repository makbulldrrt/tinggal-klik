<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\LapanganResource;
use App\Models\Lapangan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LapanganController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $lapangan = Lapangan::where('status', 'tersedia')
            ->when($request->search, function ($query, $search) {
                $query->where('nama_lapangan', 'LIKE', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                return $query->where('jenis_olahraga', $category);
            })
            ->paginate(10);

        return LapanganResource::collection($lapangan);
    }

    public function show(int $id): LapanganResource|JsonResponse
    {
        $lapangan = Lapangan::with(['ulasan.user'])->find($id);

        if (! $lapangan || $lapangan->status !== 'tersedia') {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        return new LapanganResource($lapangan);
    }
}
