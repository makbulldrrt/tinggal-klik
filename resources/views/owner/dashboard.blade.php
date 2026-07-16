<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="History Transaksi Owner — Tinggal Klik">
    <title>History Transaksi — Tinggal Klik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } };
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.625rem; font-size:0.875rem; font-weight:500; color:#94a3b8; transition:background 0.15s,color 0.15s; }
        .sidebar-link:hover { background:rgba(255,255,255,0.06); color:#f1f5f9; }
        .sidebar-link.active { background:rgba(16,185,129,0.15); color:#34d399; }
        .table-row { transition:background 0.12s; }
        .table-row:hover { background:#f8fafc; }
        ::-webkit-scrollbar { width:5px; height:5px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
<div class="flex h-screen overflow-hidden">
 
@include('owner.partials.sidebar')
 
<div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
        <div>
            <h1 class="text-lg font-semibold text-slate-900">History Transaksi</h1>
            <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('owner.withdrawal.create') }}" id="btn-tarik-dana-header" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-sm hover:from-emerald-600 hover:to-teal-600 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Kelola Finansial
            </a>
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold">
                {{ strtoupper(substr(auth()->user()->name ?? 'O', 0, 1)) }}
            </div>
        </div>
    </header>
 
    <main class="flex-1 overflow-y-auto px-8 py-7 space-y-7">
 
        @if(session('success'))
        <div id="alert-success" class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <!-- Filter Form -->
        <form method="GET" action="{{ route('owner.dashboard') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Cari</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all bg-slate-50/50">
            </div>

            <div class="w-full md:w-48">
                <label for="bulan" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Bulan</label>
                <select id="bulan" name="bulan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all bg-slate-50/50">
                    <option value="">Semua Bulan</option>
                    @foreach([
                        '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', 
                        '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', 
                        '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                    ] as $num => $name)
                        <option value="{{ $num }}" {{ (request('bulan') ?? request('month')) == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-36">
                <label for="tahun" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tahun</label>
                <select id="tahun" name="tahun" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all bg-slate-50/50">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y') + 1; $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ (request('tahun') ?? request('year')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="w-full md:w-auto flex gap-2">
                @if(request()->anyFilled(['search', 'bulan', 'month', 'tahun', 'year']))
                    <a href="{{ route('owner.dashboard') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all text-center whitespace-nowrap">
                        Reset
                    </a>
                @endif
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 transition-all shadow-sm whitespace-nowrap flex-1 md:flex-initial">
                    Filter
                </button>
            </div>
        </form>

        <section id="transaksi-table" aria-label="Riwayat Transaksi">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900">Riwayat Transaksi Lapangan</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Data booking untuk lapangan milik Anda</p>
                    </div>
                    <a href="{{ route('owner.lapangan.index') }}" id="btn-kelola-lapangan" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 transition-colors">Kelola Lapangan &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50/70">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Lapangan</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Jam</th>
                                <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Net Amount</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($transaksi as $booking)
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($booking->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800 text-sm leading-tight">{{ $booking->user->name ?? '—' }}</p>
                                            <p class="text-xs text-slate-400">{{ $booking->user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-medium text-slate-700 text-sm">{{ $booking->lapangan->nama_lapangan ?? '—' }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->lapangan->jenis_olahraga ?? '' }}</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($booking->tanggal_main ?? $booking->created_at)->format('d M Y') }}</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="text-sm text-slate-700">{{ $booking->jam_mulai ?? '—' }}</p>
                                    @if(isset($booking->durasi))
                                    <p class="text-xs text-slate-400">{{ $booking->durasi }} jam</p>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right whitespace-nowrap">
                                    <p class="font-semibold text-slate-900 text-sm">Rp {{ number_format($booking->transaction->net_amount ?? $booking->total_harga ?? 0, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    @php
                                        $st = strtolower($booking->transaction->status_pembayaran ?? $booking->status ?? 'pending');
                                        $bc = match($st) {
                                            'paid','lunas','success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'pending','unpaid'       => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'canceled','cancelled','batal' => 'bg-red-50 text-red-600 border-red-200',
                                            default => 'bg-slate-100 text-slate-500 border-slate-200',
                                        };
                                        $dc = match($st) {
                                            'paid','lunas','success' => 'bg-emerald-500',
                                            'pending','unpaid'       => 'bg-amber-500',
                                            'canceled','cancelled','batal' => 'bg-red-500',
                                            default => 'bg-slate-400',
                                        };
                                        $bl = match($st) {
                                            'paid'    => 'Dibayar',
                                            'lunas'   => 'Lunas',
                                            'success' => 'Sukses',
                                            'pending' => 'Pending',
                                            'unpaid'  => 'Belum Dibayar',
                                            'canceled','cancelled' => 'Dibatalkan',
                                            'batal'   => 'Batal',
                                            default   => ucfirst($st),
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $bc }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dc }}"></span>
                                        {{ $bl }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <svg class="w-10 h-10 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <p class="text-sm font-medium">Belum ada transaksi</p>
                                        <p class="text-xs">Booking untuk lapangan Anda akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($transaksi->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $transaksi->links() }}
                </div>
                @endif
            </div>
        </section>

    </main>
</div>

</div>
</body>
</html>
