<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogLapanganController extends Controller
{
    private const PER_PAGE = 9;

    public function index(Request $request): View
    {
        $search = trim(strip_tags($request->query('search', '')));
        $jenis  = trim(strip_tags($request->query('jenis',  'semua')));

        $query = Lapangan::query()->with('owner:id,name');

        if (auth()->check() && auth()->user()->role === 'owner') {
            $query->where('user_id', auth()->id());
        }

        $courts = $query
            ->searchNama($search)
            ->jenisOlahraga($jenis)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('lapangan.index', compact('courts'));
    }

    public function show($id): View
    {
        $lapangan = Lapangan::with(['owner:id,name', 'ulasan.user'])->findOrFail($id);

        return view('lapangan.show', compact('lapangan'));
    }
}
