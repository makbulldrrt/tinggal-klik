<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard — Tinggal Klik Field Rental Management">
    <title>Admin Dashboard — Tinggal Klik</title>
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
        .sidebar-link.active { background:rgba(14,165,233,0.15); color:#38bdf8; }
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

{{-- SIDEBAR --}}
<aside class="w-64 flex-shrink-0 bg-slate-900 flex flex-col">
    <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-400 to-blue-600 flex items-center justify-center shadow-lg">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
        </div>
        <div>
            <p class="text-white font-semibold text-sm leading-tight">Tinggal Klik</p>
            <p class="text-slate-400 text-xs">Admin Panel</p>
        </div>
    </div>
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Main</p>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.lapangan.index') }}" class="sidebar-link">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Kelola Lapangan
        </a>
        <a href="#" class="sidebar-link">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Bookings
        </a>
        <a href="#" class="sidebar-link">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            Transaksi
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
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-slate-400 text-xs truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
        <div>
            <h1 class="text-lg font-semibold text-slate-900">Dashboard</h1>
            <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if($pending_bookings > 0)
            <span id="topbar-pending-badge" class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-full border border-amber-200">
                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                {{ $pending_bookings }} Menunggu Konfirmasi
            </span>
            @endif
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-8 py-7 space-y-7">

        {{-- KPI CARDS --}}
        <section id="kpi-cards" aria-label="KPI Statistics">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                {{-- Revenue --}}
                <div id="card-revenue" class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-sky-50 rounded-full opacity-60"></div>
                    <div class="flex items-start justify-between relative">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-slate-900 leading-tight">Rp {{ number_format($total_revenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-400 mt-1">dari transaksi lunas</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-sky-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50">
                        <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                            Total akumulatif
                        </span>
                    </div>
                </div>

                {{-- Total Bookings --}}
                <div id="card-bookings" class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-violet-50 rounded-full opacity-60"></div>
                    <div class="flex items-start justify-between relative">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Total Booking</p>
                            <p class="text-2xl font-bold text-slate-900 leading-tight">{{ number_format($total_bookings) }}</p>
                            <p class="text-xs text-slate-400 mt-1">semua pemesanan</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50">
                        <span class="text-xs text-slate-400 font-medium">Seluruh periode</span>
                    </div>
                </div>

                {{-- Pending --}}
                <div id="card-pending" class="stat-card bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 {{ $pending_bookings > 0 ? 'bg-amber-50' : 'bg-slate-50' }} rounded-full opacity-60"></div>
                    <div class="flex items-start justify-between relative">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Menunggu Persetujuan</p>
                            <div class="flex items-center gap-2">
                                <p class="text-2xl font-bold text-slate-900 leading-tight">{{ $pending_bookings }}</p>
                                @if($pending_bookings > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">Perlu Aksi</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-400 mt-1">booking pending</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl {{ $pending_bookings > 0 ? 'bg-amber-50' : 'bg-slate-50' }} flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 {{ $pending_bookings > 0 ? 'text-amber-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50">
                        @if($pending_bookings > 0)
                        <span class="inline-flex items-center gap-1 text-xs text-amber-600 font-medium">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                            Membutuhkan konfirmasi
                        </span>
                        @else
                        <span class="text-xs text-emerald-600 font-medium">&#10003; Semua sudah ditangani</span>
                        @endif
                    </div>
                </div>

            </div>
        </section>

        {{-- TRANSACTION TABLE + MAPS --}}
        <section id="main-grid" aria-label="Transaksi dan Lokasi" class="grid grid-cols-1 xl:grid-cols-10 gap-5">

            {{-- Transaction Table 70% --}}
            <div class="xl:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900">Manajemen Transaksi Terbaru</h2>
                        <p class="text-xs text-slate-400 mt-0.5">5 booking terkini</p>
                    </div>
                    <a href="#" id="btn-lihat-semua" class="text-xs font-medium text-sky-600 hover:text-sky-700 transition-colors">Lihat Semua &rarr;</a>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50/70">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Lapangan</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Tanggal &amp; Waktu</th>
                                <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Total</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recent_bookings as $booking)
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
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
                                    <p class="text-xs text-slate-400">
                                        {{ isset($booking->jam_mulai) ? $booking->jam_mulai . ' (' . $booking->durasi . ' Jam)' : \Carbon\Carbon::parse($booking->created_at)->format('H:i') }}
                                    </p>
                                </td>
                                <td class="px-4 py-4 text-right whitespace-nowrap">
                                    <p class="font-semibold text-slate-900 text-sm">Rp {{ number_format($booking->transaction->total_harga ?? $booking->total_harga ?? 0, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    @php
                                        $rawStatus = strtolower($booking->transaction->status_pembayaran ?? $booking->status ?? 'pending');
                                        $badgeClass = match($rawStatus) {
                                            'success','lunas', 'paid'       => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'pending','unpaid'              => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'canceled','cancelled','batal'  => 'bg-red-50 text-red-600 border-red-200',
                                            default                         => 'bg-slate-100 text-slate-500 border-slate-200',
                                        };
                                        $dotClass = match($rawStatus) {
                                            'success','lunas', 'paid'       => 'bg-emerald-500',
                                            'pending','unpaid'              => 'bg-amber-500',
                                            'canceled','cancelled','batal'  => 'bg-red-500',
                                            default                         => 'bg-slate-400',
                                        };
                                        $badgeLabel = match($rawStatus) {
                                            'success'                       => 'Success',
                                            'lunas'                         => 'Lunas',
                                            'paid'                          => 'Dibayar',
                                            'pending'                       => 'Pending',
                                            'unpaid'                        => 'Belum Dibayar',
                                            'canceled','cancelled'          => 'Dibatalkan',
                                            'batal'                         => 'Batal',
                                            default                         => ucfirst($rawStatus),
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                        {{ $badgeLabel }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    @php $actionStatus = strtolower($booking->transaction->status_pembayaran ?? $booking->status ?? ''); @endphp
                                    <a href="#" id="btn-detail-{{ $booking->id }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ in_array($actionStatus, ['pending', 'unpaid']) ? 'bg-sky-600 text-white hover:bg-sky-700' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ in_array($actionStatus, ['pending', 'unpaid']) ? 'Konfirmasi' : 'Detail' }}
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <svg class="w-10 h-10 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <p class="text-sm font-medium">Belum ada booking</p>
                                        <p class="text-xs">Data booking akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Google Maps 30% --}}
            <div class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-900">Lokasi Bisnis</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Google Maps Preview</p>
                </div>
                <div class="flex-1 p-4 flex flex-col gap-3">
                    <div class="relative rounded-xl overflow-hidden bg-slate-100" style="min-height:220px;" id="maps-container">
                        <iframe id="google-maps-iframe" title="Lokasi Lapangan" class="absolute inset-0 w-full h-full" style="border:0;" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.39553291272!2d106.7271985!3d-6.2297465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1699000000000">
                        </iframe>
                        <div class="absolute top-2 left-2 z-10 bg-white/90 backdrop-blur-sm rounded-lg px-2.5 py-1.5 shadow-sm flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-xs font-semibold text-slate-700">Google Maps Terintegrasi</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3.5 space-y-2.5">
                        <div class="flex items-start gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-sky-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-700">Alamat Usaha</p>
                                <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">Jl. Lapangan Raya No.1<br>Jakarta, Indonesia</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-700">Telepon</p>
                                <p class="text-xs text-slate-400">+62 21 0000-0000</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-700">Jam Operasional</p>
                                <p class="text-xs text-slate-400">07:00 – 22:00 WIB</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="btn-update-location" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-semibold text-sky-600 border border-sky-200 bg-sky-50 hover:bg-sky-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Perbarui Lokasi &amp; Embed
                    </a>
                </div>
            </div>

        </section>
    </main>
</div>

</div>
</body>
</html>
