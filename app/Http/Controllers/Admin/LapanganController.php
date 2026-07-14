<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::latest()->paginate(10);
        return view('admin.lapangan.index', compact('lapangan'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lapangan'  => 'required|string|max:255',
            'jenis_olahraga' => 'nullable|string|max:100',
            'harga_per_jam'  => 'required|integer|min:1',
            'deskripsi'      => 'required|string',
            'foto_lapangan'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:tersedia,tidak tersedia,pemeliharaan',
        ]);

        if ($request->hasFile('foto_lapangan')) {
            $validated['foto_lapangan'] = $request->file('foto_lapangan')->store('lapangan', 'public');
        }

        Lapangan::create($validated);

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(Lapangan $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $validated = $request->validate([
            'nama_lapangan'  => 'required|string|max:255',
            'jenis_olahraga' => 'nullable|string|max:100',
            'harga_per_jam'  => 'required|integer|min:1',
            'deskripsi'      => 'required|string',
            'foto_lapangan'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:tersedia,tidak tersedia,pemeliharaan',
        ]);

        if ($request->hasFile('foto_lapangan')) {
            $validated['foto_lapangan'] = $request->file('foto_lapangan')->store('lapangan', 'public');
        }

        $lapangan->update($validated);

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Lapangan $lapangan)
    {
        $lapangan->delete();

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil dihapus.');
    }
}
