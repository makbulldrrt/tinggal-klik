<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    private function ownedQuery()
    {
        return Lapangan::where('owner_id', auth()->id());
    }

    public function index(): JsonResponse
    {
        return response()->json($this->ownedQuery()->get());
    }

    public function show(int $id): JsonResponse
    {
        $lapangan = $this->ownedQuery()->find($id);

        if (! $lapangan) {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        return response()->json($lapangan);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'jenis'         => ['required', 'string', 'in:Futsal,Badminton,Basket'],
            'harga_per_jam' => ['required', 'integer', 'min:0'],
            'deskripsi'     => ['nullable', 'string'],
            'status'        => ['nullable', 'boolean'],
        ]);

        $lapangan = Lapangan::create(array_merge($validated, ['owner_id' => auth()->id()]));

        return response()->json($lapangan, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $lapangan = $this->ownedQuery()->find($id);

        if (! $lapangan) {
            return response()->json(['message' => 'Lapangan tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'nama'          => ['sometimes', 'string', 'max:255'],
            'jenis'         => ['sometimes', 'string', 'in:Futsal,Badminton,Basket'],
            'harga_per_jam' => ['sometimes', 'integer', 'min:0'],
            'deskripsi'     => ['nullable', 'string'],
            'status'        => ['nullable', 'boolean'],
        ]);

        $lapangan->update($validated);

        return response()->json($lapangan);
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
