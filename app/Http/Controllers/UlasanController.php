<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangan,id',
            'rating'      => 'required|integer|min:1|max:5',
            'komentar'    => 'nullable|string|max:1000',
        ]);

        DB::table('ulasan')->insert([
            'user_id'     => auth()->id(),
            'lapangan_id' => $validated['lapangan_id'],
            'rating'      => $validated['rating'],
            'komentar'    => $validated['komentar'] ?? '',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }
}
