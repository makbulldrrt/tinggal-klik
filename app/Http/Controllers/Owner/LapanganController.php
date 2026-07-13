<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::where('user_id', auth()->id())->latest()->paginate(10);
        return view('owner.lapangan.index', compact('lapangan'));
    }

    public function create()
    {
        return view('owner.lapangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lapangan'  => 'required|string|max:255',
            'jenis_olahraga' => 'nullable|string|max:100',
            'harga_per_jam'  => 'required|integer|min:1',
            'deskripsi'      => 'required|string',
            'foto_lapangan'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'lokasi'         => 'nullable|string|max:255',
            'status'         => 'required|in:tersedia,pemeliharaan',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('foto_lapangan')) {
            $validated['foto_lapangan'] = $request->file('foto_lapangan')->store('lapangan', 'public');
        }

        Lapangan::create($validated);

        return redirect()->route('owner.lapangan.index')->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(Lapangan $lapangan)
    {
        if ($lapangan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('owner.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        if ($lapangan->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_lapangan'  => 'required|string|max:255',
            'jenis_olahraga' => 'nullable|string|max:100',
            'harga_per_jam'  => 'required|integer|min:1',
            'deskripsi'      => 'required|string',
            'foto_lapangan'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'lokasi'         => 'nullable|string|max:255',
            'status'         => 'required|in:tersedia,pemeliharaan',
        ]);

        if ($request->hasFile('foto_lapangan')) {
            $validated['foto_lapangan'] = $request->file('foto_lapangan')->store('lapangan', 'public');
        }

        $lapangan->update($validated);

        return redirect()->route('owner.lapangan.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->user_id !== auth()->id()) {
            abort(403);
        }

        $lapangan->delete();

        return redirect()->route('owner.lapangan.index')->with('success', 'Lapangan berhasil dihapus.');
    }
}
