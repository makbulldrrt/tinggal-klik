@extends('layouts.admin')

@section('title', 'Riwayat Finansial')
@section('page_title', 'Riwayat Finansial')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-sky-50 rounded-full opacity-60"></div>
            <div class="flex items-start justify-between relative">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Pendapatan Platform</p>
                    <p class="text-2xl font-bold text-slate-900 leading-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-400 mt-1">2% dari setiap transaksi</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-sky-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-50 rounded-full opacity-60"></div>
            <div class="flex items-start justify-between relative">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Total Owner / Mitra</p>
                    <p class="text-2xl font-bold text-slate-900 leading-tight">{{ $totalOwner }}</p>
                    <p class="text-xs text-slate-400 mt-1">mitra pengelola lapangan</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-violet-50 rounded-full opacity-60"></div>
            <div class="flex items-start justify-between relative">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-slate-900 leading-tight">{{ $totalPelanggan }}</p>
                    <p class="text-xs text-slate-400 mt-1">pengguna terdaftar</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-amber-50 rounded-full opacity-60"></div>
            <div class="flex items-start justify-between relative">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Penarikan Pending</p>
                    <div class="flex items-center gap-2">
                        <p class="text-2xl font-bold text-slate-900 leading-tight">{{ $pendingWithdrawals }}</p>
                        @if($pendingWithdrawals > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">Perlu Aksi</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400 mt-1">menunggu persetujuan</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.transactions.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[240px]">
            <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pencarian</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari kode transaksi, nama pelanggan, atau owner..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring focus:ring-sky-200 transition-all text-sm outline-none">
        </div>
        <div class="w-48">
            <label for="type" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tipe</label>
            <select id="type" name="type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring focus:ring-sky-200 transition-all text-sm outline-none">
                <option value="">Semua Tipe</option>
                <option value="transaksi" {{ request('type') === 'transaksi' ? 'selected' : '' }}>Transaksi Pelanggan</option>
                <option value="penarikan" {{ request('type') === 'penarikan' ? 'selected' : '' }}>Penarikan Dana Owner</option>
            </select>
        </div>
        <div class="w-48">
            <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
            <select id="status" name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring focus:ring-sky-200 transition-all text-sm outline-none">
                <option value="">Semua Status</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid / Lunas (Transaksi)</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved (Penarikan)</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected (Penarikan)</option>
            </select>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.transactions.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">Reset</a>
            <button type="submit" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-semibold hover:bg-sky-700 transition-colors shadow-sm shadow-sky-100">Filter</button>
        </div>
    </form>

    @if(request('type') !== 'penarikan')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-900">Riwayat Transaksi Pelanggan</h2>
            <p class="text-xs text-slate-400 mt-0.5">Biaya admin platform sebesar 2% dari nilai kotor</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/70">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Kode Transaksi</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Lapangan</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Nilai Kotor</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Biaya Admin (2%)</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Nilai Bersih Owner</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $tx)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-slate-600">{{ $tx->kode_transaksi }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-800">{{ $tx->pemesanan->user->name ?? '—' }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-700">{{ $tx->pemesanan->lapangan->nama_lapangan ?? '—' }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap text-slate-600">Rp {{ number_format($tx->gross_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap text-sky-600 font-medium">Rp {{ number_format($tx->platform_fee, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap text-emerald-600 font-semibold">Rp {{ number_format($tx->net_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-center whitespace-nowrap">
                            @php
                                $txSt = strtolower($tx->status_pembayaran);
                                $txBc = match($txSt) {
                                    'paid','lunas','success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'pending','unpaid'       => 'bg-amber-50 text-amber-700 border-amber-200',
                                    default                  => 'bg-red-50 text-red-700 border-red-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $txBc }}">
                                {{ ucfirst($txSt) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400 text-xs">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator && $transactions->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $transactions->appends(request()->except('page_tx'))->links() }}
        </div>
        @endif
    </div>
    @endif

    @if(request('type') !== 'transaksi')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-900">Riwayat Penarikan Dana Owner</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/70">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Owner</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Tujuan Transfer</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Nominal</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Tanggal Diajukan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($withdrawals as $wd)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $wd->user->name ?? '—' }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-600">{{ $wd->bank_tujuan }} - {{ $wd->nomor_rekening }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap font-bold text-slate-900">Rp {{ number_format($wd->jumlah_penarikan, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-center whitespace-nowrap">
                            @php
                                $wdBc = match($wd->status) {
                                    'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                    default    => 'bg-amber-50 text-amber-700 border-amber-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $wdBc }}">
                                {{ ucfirst($wd->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $wd->created_at->format('d M Y, H:i') }} WIB</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-xs">Belum ada riwayat penarikan dana.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($withdrawals instanceof \Illuminate\Pagination\LengthAwarePaginator && $withdrawals->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $withdrawals->appends(request()->except('page_wd'))->links() }}
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
