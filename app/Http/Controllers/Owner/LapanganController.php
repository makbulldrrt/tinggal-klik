<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $ownerId = auth()->id();

        $lapangan = Lapangan::where('user_id', $ownerId)->latest()->paginate(10);

        $ownerLapanganIds = Lapangan::where('user_id', $ownerId)->pluck('id');

        $paidTransactions = Transaction::whereIn('status_pembayaran', ['paid', 'lunas'])
            ->with('pemesanan.lapangan')
            ->whereHas('pemesanan', function ($q) use ($ownerLapanganIds) {
                $q->whereIn('lapangan_id', $ownerLapanganIds);
            })
            ->get();

        $totalKotor    = $paidTransactions->sum('gross_amount');
        $totalPotongan = $paidTransactions->sum('platform_fee');
        $totalBersih   = $paidTransactions->sum('net_amount');

        $totalDitarik = (float) Withdrawal::where('user_id', $ownerId)
            ->where('status', 'approved')
            ->sum('jumlah_penarikan');

        $sisaSaldo = $totalBersih - $totalDitarik;

        $currentYear = now()->year;

        $monthlyLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $monthlyData   = array_fill(0, 12, 0.0);

        foreach ($paidTransactions as $t) {
            $tYear  = (int) date('Y', strtotime($t->created_at));
            $tMonth = (int) date('n', strtotime($t->created_at));
            if ($tYear === $currentYear) {
                $monthlyData[$tMonth - 1] += (float) $t->net_amount;
            }
        }

        $sportGroups = [];
        foreach ($paidTransactions as $t) {
            $jenis = $t->pemesanan->lapangan->jenis_olahraga ?? 'Lainnya';
            if (!isset($sportGroups[$jenis])) {
                $sportGroups[$jenis] = 0.0;
            }
            $sportGroups[$jenis] += (float) $t->net_amount;
        }

        $sportLabels = array_keys($sportGroups);
        $sportData   = array_values($sportGroups);

        return view('owner.lapangan.index', compact(
            'lapangan',
            'totalKotor',
            'totalPotongan',
            'totalBersih',
            'totalDitarik',
            'sisaSaldo',
            'monthlyLabels',
            'monthlyData',
            'sportLabels',
            'sportData'
        ));
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
