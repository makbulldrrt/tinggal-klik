<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\LapanganResource;
use App\Models\Lapangan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LapanganController extends Controller
{
    private function ownedQuery()
    {
        return Lapangan::where('user_id', auth()->id());
    }

    public function index(): AnonymousResourceCollection
    {
        return LapanganResource::collection($this->ownedQuery()->get());
    }

    public function show(int $id): LapanganResource|JsonResponse
    {
        $lapangan = $this->ownedQuery()->find($id);

        if (! $lapangan) {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        return new LapanganResource($lapangan);
    }

    public function store(Request $request): LapanganResource
    {
        $validated = $request->validate([
            'nama'         => ['required', 'string', 'max:255'],
            'jenis'        => ['required', 'string', 'in:Futsal,Badminton,Basket'],
            'harga_per_jam'=> ['required', 'integer', 'min:0'],
            'deskripsi'    => ['nullable', 'string'],
            'status'       => ['required', 'boolean'],
        ]);

        $lapangan = Lapangan::create([
            'user_id'       => auth()->id(),
            'nama_lapangan' => $validated['nama'],
            'jenis_olahraga'=> $validated['jenis'],
            'harga_per_jam' => $validated['harga_per_jam'],
            'deskripsi'     => $validated['deskripsi'] ?? null,
            'status'        => $validated['status'] ? 'tersedia' : 'pemeliharaan',
        ]);

        return new LapanganResource($lapangan);
    }

    public function update(Request $request, int $id): LapanganResource|JsonResponse
    {
        $lapangan = $this->ownedQuery()->find($id);

        if (! $lapangan) {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'nama'         => ['sometimes', 'string', 'max:255'],
            'jenis'        => ['sometimes', 'string', 'in:Futsal,Badminton,Basket'],
            'harga_per_jam'=> ['sometimes', 'integer', 'min:0'],
            'deskripsi'    => ['nullable', 'string'],
            'status'       => ['sometimes', 'boolean'],
        ]);

        $lapangan->update(array_filter([
            'nama_lapangan' => $validated['nama'] ?? null,
            'jenis_olahraga'=> $validated['jenis'] ?? null,
            'harga_per_jam' => $validated['harga_per_jam'] ?? null,
            'deskripsi'     => $validated['deskripsi'] ?? null,
            'status'        => isset($validated['status'])
                ? ($validated['status'] ? 'tersedia' : 'pemeliharaan')
                : null,
        ], fn ($v) => $v !== null));

        return new LapanganResource($lapangan->fresh());
    }

    public function destroy(int $id): JsonResponse
    {
        $lapangan = $this->ownedQuery()->find($id);

        if (! $lapangan) {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        $lapangan->delete();

        return response()->json(['message' => 'Lapangan berhasil dihapus.']);
    }
}
