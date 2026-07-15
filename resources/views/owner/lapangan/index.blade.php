<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelola Lapangan & Revenue Analytics — Tinggal Klik Owner">
    <title>Lapangan Saya — Tinggal Klik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } };</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.625rem; font-size:0.875rem; font-weight:500; color:#94a3b8; transition:background 0.15s,color 0.15s; cursor:pointer; }
        .sidebar-link:hover { background:rgba(255,255,255,0.06); color:#f1f5f9; }
        .sidebar-link.active { background:rgba(16,185,129,0.15); color:#34d399; }
        .table-row { transition:background 0.12s; }
        .table-row:hover { background:#f8fafc; }
        .kpi-card { position:relative; overflow:hidden; }
        .kpi-card::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%); pointer-events:none; border-radius:inherit; }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .animate-in { animation: fadeInUp 0.35s ease forwards; }
        .chart-container { position:relative; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
<div class="flex h-screen overflow-hidden">

@include('owner.partials.sidebar')


<div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
        <div>
            <h1 id="page-title" class="text-lg font-semibold text-slate-900">Lapangan Saya</h1>
            <p id="page-subtitle" class="text-xs text-slate-400 mt-0.5">Kelola semua lapangan yang Anda daftarkan</p>
        </div>
        <a href="{{ route('owner.lapangan.create') }}" id="btn-tambah-lapangan" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-sm hover:from-emerald-600 hover:to-teal-600 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Lapangan
        </a>
    </header>

    <main class="flex-1 overflow-y-auto px-8 py-7">

        @if(session('success'))
        <div id="alert-success" class="flex items-center gap-3 p-4 mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <div id="container-lapangan">

            <form method="GET" action="{{ route('owner.lapangan.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 px-5 py-4 mb-4 flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Cari Lapangan</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lapangan..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                    </div>
                </div>
                <div class="min-w-[150px]">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kategori</label>
                    <select name="kategori" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition bg-white">
                        <option value="">Semua Kategori</option>
                        <option value="Futsal"    {{ request('kategori') === 'Futsal'    ? 'selected' : '' }}>Futsal</option>
                        <option value="Badminton" {{ request('kategori') === 'Badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="Basket"    {{ request('kategori') === 'Basket'    ? 'selected' : '' }}>Basket</option>
                        <option value="Tennis"    {{ request('kategori') === 'Tennis'    ? 'selected' : '' }}>Tennis</option>
                        <option value="Voli"      {{ request('kategori') === 'Voli'      ? 'selected' : '' }}>Voli</option>
                    </select>
                </div>
                <div class="min-w-[140px]">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Status</label>
                    <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition bg-white">
                        <option value="">Semua Status</option>
                        <option value="tersedia"     {{ request('status') === 'tersedia'     ? 'selected' : '' }}>Tersedia</option>
                        <option value="pemeliharaan" {{ request('status') === 'pemeliharaan' ? 'selected' : '' }}>Pemeliharaan</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-500 text-white hover:bg-emerald-600 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/></svg>
                        Cari
                    </button>
                    <a href="{{ route('owner.lapangan.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                </div>
            </form>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50/70">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Lapangan</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Lokasi</th>
                                <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Harga/Jam</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($lapangan as $item)
                            <tr class="table-row">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->foto_lapangan)
                                        <img src="{{ asset('storage/' . $item->foto_lapangan) }}" alt="{{ $item->nama_lapangan }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                        @else
                                        <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                        </div>
                                        @endif
                                        <p class="font-medium text-slate-800">{{ $item->nama_lapangan }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $item->jenis_olahraga ?? '—' }}</td>
                                <td class="px-4 py-4 text-slate-500 text-xs max-w-xs truncate">{{ $item->lokasi ?? '—' }}</td>
                                <td class="px-4 py-4 text-right font-semibold text-slate-900">Rp {{ number_format($item->harga_per_jam, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-center">
                                    @if($item->status === 'tersedia')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Tersedia
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Pemeliharaan
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('owner.lapangan.edit', $item->id) }}" id="btn-edit-{{ $item->id }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-sky-50 text-sky-600 hover:bg-sky-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('owner.lapangan.destroy', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="btn-hapus-{{ $item->id }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <svg class="w-10 h-10 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                        <p class="text-sm font-medium">Belum ada lapangan</p>
                                        <p class="text-xs">Tambahkan lapangan pertama Anda.</p>
                                        <a href="{{ route('owner.lapangan.create') }}" class="mt-2 px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-500 text-white hover:bg-emerald-600 transition-colors">Tambah Lapangan</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($lapangan->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $lapangan->links() }}
                </div>
                @endif
            </div>
        </div>

        <div id="container-revenue" class="hidden animate-in">

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

                <div class="kpi-card rounded-2xl p-6 bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-emerald-100 bg-white/10 px-2.5 py-1 rounded-full">Kotor</span>
                    </div>
                    <p class="text-emerald-100 text-xs font-medium mb-1">Total Pendapatan Kotor</p>
                    <p id="kpi-kotor" class="text-2xl font-extrabold tracking-tight">Rp {{ number_format($totalKotor, 0, ',', '.') }}</p>
                </div>

                <div class="kpi-card rounded-2xl p-6 bg-gradient-to-br from-violet-500 to-purple-700 text-white shadow-lg shadow-violet-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-violet-100 bg-white/10 px-2.5 py-1 rounded-full">Bersih</span>
                    </div>
                    <p class="text-violet-100 text-xs font-medium mb-1">Total Pendapatan Bersih</p>
                    <p id="kpi-bersih" class="text-2xl font-extrabold tracking-tight">Rp {{ number_format($totalBersih, 0, ',', '.') }}</p>
                </div>

                <div class="kpi-card rounded-2xl p-6 bg-gradient-to-br from-rose-500 to-pink-600 text-white shadow-lg shadow-rose-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-rose-100 bg-white/10 px-2.5 py-1 rounded-full">Ditarik</span>
                    </div>
                    <p class="text-rose-100 text-xs font-medium mb-1">Total Dana Ditarik</p>
                    <p id="kpi-ditarik" class="text-2xl font-extrabold tracking-tight">Rp {{ number_format($totalDitarik, 0, ',', '.') }}</p>
                </div>

                <div class="kpi-card rounded-2xl p-6 bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-400/20">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-amber-50 bg-white/10 px-2.5 py-1 rounded-full">Saldo</span>
                    </div>
                    <p class="text-amber-50 text-xs font-medium mb-1">Sisa Saldo Berjalan</p>
                    <p id="kpi-saldo" class="text-2xl font-extrabold tracking-tight">Rp {{ number_format($sisaSaldo, 0, ',', '.') }}</p>
                </div>

            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="mb-5">
                        <h2 class="text-sm font-bold text-slate-800">Tren Pendapatan Bulanan</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Pendapatan bersih per bulan — {{ now()->year }}</p>
                    </div>
                    <div class="chart-container" style="height:280px;">
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="mb-5">
                        <h2 class="text-sm font-bold text-slate-800">Kontribusi per Jenis Olahraga</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Distribusi pendapatan bersih berdasarkan kategori olahraga</p>
                    </div>
                    <div class="chart-container flex items-center justify-center" style="height:280px;">
                        <canvas id="sportTypeChart"></canvas>
                    </div>
                </div>

            </div>

        </div>

    </main>
</div>

</div>

<script>
    var monthlyLabels = @json($monthlyLabels);
    var monthlyData   = @json($monthlyData);
    var sportLabels   = @json($sportLabels);
    var sportData     = @json($sportData);

    var monthlyChart = null;
    var sportChart   = null;


    function showTab(tab) {
        var lapanganEl  = document.getElementById('container-lapangan');
        var revenueEl   = document.getElementById('container-revenue');
        var title       = document.getElementById('page-title');
        var subtitle    = document.getElementById('page-subtitle');
        var btnTambah   = document.getElementById('btn-tambah-lapangan');

        // Cari sidebar links berdasarkan href (kompatibel dengan partial sidebar terpusat)
        var sidebarLinks = document.querySelectorAll('aside .sidebar-link');
        var lapanganHref = '{{ route("owner.lapangan.index") }}';
        var revenueHref  = lapanganHref + '?tab=revenue';

        if (tab === 'lapangan') {
            lapanganEl.classList.remove('hidden');
            revenueEl.classList.add('hidden');
            title.textContent    = 'Lapangan Saya';
            subtitle.textContent = 'Kelola semua lapangan yang Anda daftarkan';
            btnTambah.classList.remove('hidden');
            history.replaceState(null, '', lapanganHref);
            // Update active state sidebar
            sidebarLinks.forEach(function(link) {
                if (link.getAttribute('href') === lapanganHref) {
                    link.classList.add('active');
                } else if (link.getAttribute('href') === revenueHref) {
                    link.classList.remove('active');
                }
            });
        } else {
            lapanganEl.classList.add('hidden');
            revenueEl.classList.remove('hidden');
            title.textContent    = 'Revenue Analytics';
            subtitle.textContent = 'Ringkasan keuangan lapangan Anda';
            btnTambah.classList.add('hidden');
            history.replaceState(null, '', revenueHref);
            // Update active state sidebar
            sidebarLinks.forEach(function(link) {
                if (link.getAttribute('href') === revenueHref) {
                    link.classList.add('active');
                } else if (link.getAttribute('href') === lapanganHref) {
                    link.classList.remove('active');
                }
            });
            initCharts();
        }
    }

    // Otomatis buka tab revenue jika URL mengandung ?tab=revenue
    document.addEventListener('DOMContentLoaded', function () {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'revenue') {
            showTab('revenue');
        }
    });

    function initCharts() {
        if (!monthlyChart) {
            var ctxMonthly = document.getElementById('monthlyRevenueChart').getContext('2d');
            var gradient   = ctxMonthly.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(16,185,129,0.35)');
            gradient.addColorStop(1, 'rgba(16,185,129,0)');
            monthlyChart = new Chart(ctxMonthly, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Pendapatan Bersih',
                        data: monthlyData,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#10b981',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#94a3b8',
                            bodyColor: '#f1f5f9',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(ctx) {
                                    return ' Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { size: 11 } }
                        },
                        y: {
                            grid: { color: 'rgba(148,163,184,0.1)', drawBorder: false },
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11 },
                                callback: function(val) {
                                    if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'Jt';
                                    if (val >= 1000) return 'Rp ' + (val/1000).toFixed(0) + 'Rb';
                                    return 'Rp ' + val;
                                }
                            }
                        }
                    }
                }
            });
        }

        if (!sportChart) {
            var ctxSport = document.getElementById('sportTypeChart').getContext('2d');
            var palette  = ['#10b981','#8b5cf6','#f43f5e','#f59e0b','#3b82f6','#06b6d4','#ec4899','#84cc16'];
            sportChart = new Chart(ctxSport, {
                type: 'doughnut',
                data: {
                    labels: sportLabels.length ? sportLabels : ['Belum ada data'],
                    datasets: [{
                        data: sportData.length ? sportData : [1],
                        backgroundColor: sportLabels.length ? palette.slice(0, sportLabels.length) : ['#e2e8f0'],
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#64748b',
                                font: { size: 11 },
                                padding: 16,
                                usePointStyle: true,
                                pointStyleWidth: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#94a3b8',
                            bodyColor: '#f1f5f9',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(ctx) {
                                    return ' Rp ' + ctx.parsed.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    }
</script>
</body>
</html>
