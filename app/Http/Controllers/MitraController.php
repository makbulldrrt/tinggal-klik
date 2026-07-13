<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{
    public function showForm()
    {
        return view('mitra.register');
    }

    public function registerMitra(Request $request)
    {
        $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nama_bisnis' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat_operasional' => 'required|string',
        ]);

        $user = Auth::user();

        if ($user && $user->role === 'pelanggan') {
            $user->name = $request->nama_pemilik;
            $user->role = 'owner';
            
            $user->save();
        }

        return redirect('/owner/lapangan')->with('success', 'Pendaftaran mitra berhasil! Anda sekarang adalah pemilik lapangan.');
    }
}
