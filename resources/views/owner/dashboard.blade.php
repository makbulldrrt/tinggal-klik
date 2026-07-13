<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Owner Dashboard — Kelola Lapangan & Finansial Tinggal Klik">
    <title>Owner Dashboard — Tinggal Klik</title>
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
        .stat-card { transition:transform 0.2s ease,box-shadow 0.2s ease; }
        .stat-card:hover { transform:translateY(-3px); box-shadow:0 20px 40px rgba(0,0,0,0.10); }
        .table-row { transition:background 0.12s; }
        .table-row:hover { background:#f8fafc; }
        ::-webkit-scrollbar { width:5px; height:5px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
<div class="flex h-screen overflow-hidden">

<aside class="w-64 flex-shrink-0 bg-slate-900 flex flex-col">
    <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center shadow-lg">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
        </div>
        <div>
            <p class="text-white font-semibold text-sm leading-tight">Tinggal Klik</p>
            <p class="text-slate-400 text-xs">Owner Panel</p>
        </div>
    </div>
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Main</p>
        <a href="{{ route('owner.dashboard') }}" id="nav-dashboard" class="sidebar-link active">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('owner.lapangan.index') }}" id="nav-lapangan" class="sidebar-link">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Kelola Lapangan
        </a>
        <a href="{{ route('owner.withdrawal.create') }}" id="nav-withdrawal" class="sidebar-link">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            Tarik Dana
        </a>
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Account</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>
    <div class="px-4 py-4 border-t border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'O', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Owner' }}</p>
                <p class="text-slate-400 text-xs truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
    </div>
</aside>

<div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
        <div>
            <h1 class="text-lg font-semibold text-slate-900">Dashboard Finansial</h1>
            <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('owner.withdrawal.create') }}" id="btn-tarik-dana-header" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-sm hover:from-emerald-600 hover:to-teal-600 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Tarik Dana
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

        <section id="kpi-cards" aria-label="Financial KPI">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <div id="card-pendapatan" class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-50 rounded-full opacity-60"></div>
                    <div class="flex items-start justify-between relative">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Total Pendapatan Bersih</p>
                            <p class="text-2xl font-bold text-slate-900 leading-tight">Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-400 mt-1">dari transaksi lunas</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50">
                        <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                            Total akumulatif
                        </span>
                    </div>
                </div>

                <div id="card-pending" class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 {{ $totalPending > 0 ? 'bg-amber-50' : 'bg-slate-50' }} rounded-full opacity-60"></div>
                    <div class="flex items-start justify-between relative">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Dana Dikunci / Pending</p>
                            <p class="text-2xl font-bold text-slate-900 leading-tight">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-400 mt-1">sedang diproses admin</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl {{ $totalPending > 0 ? 'bg-amber-50' : 'bg-slate-50' }} flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 {{ $totalPending > 0 ? 'text-amber-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50">
                        @if($totalPending > 0)
                        <span class="inline-flex items-center gap-1 text-xs text-amber-600 font-medium">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                            Menunggu persetujuan
                        </span>
                        @else
                        <span class="text-xs text-slate-400 font-medium">Tidak ada penarikan pending</span>
                        @endif
                    </div>
                </div>

                <div id="card-saldo" class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-sky-50 rounded-full opacity-60"></div>
                    <div class="flex items-start justify-between relative">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Saldo Bisa Ditarik</p>
                            <p class="text-2xl font-bold {{ $saldoTersedia > 0 ? 'text-sky-600' : 'text-slate-400' }} leading-tight">Rp {{ number_format(max(0, $saldoTersedia), 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-400 mt-1">tersedia sekarang</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-sky-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50">
                        @if($saldoTersedia > 0)
                        <a href="{{ route('owner.withdrawal.create') }}" class="inline-flex items-center gap-1 text-xs text-sky-600 font-semibold hover:text-sky-700 transition-colors">
                            Tarik Sekarang &rarr;
                        </a>
                        @else
                        <span class="text-xs text-slate-400 font-medium">Belum ada saldo</span>
                        @endif
                    </div>
                </div>

            </div>
        </section>

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
                            @forelse($riwayatBooking as $booking)
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
            </div>
        </section>

    </main>
</div>

</div>
</body>
</html>
