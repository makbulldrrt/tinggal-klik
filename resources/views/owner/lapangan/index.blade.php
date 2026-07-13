<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelola Lapangan Saya — Tinggal Klik Owner">
    <title>Lapangan Saya — Tinggal Klik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } };</script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.625rem; font-size:0.875rem; font-weight:500; color:#94a3b8; transition:background 0.15s,color 0.15s; }
        .sidebar-link:hover { background:rgba(255,255,255,0.06); color:#f1f5f9; }
        .sidebar-link.active { background:rgba(16,185,129,0.15); color:#34d399; }
        .table-row { transition:background 0.12s; }
        .table-row:hover { background:#f8fafc; }
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
        <a href="{{ route('lapangan.index') }}" class="sidebar-link">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard Lapangan
        </a>
        <a href="{{ route('owner.lapangan.index') }}" class="sidebar-link active">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Kelola Lapangan
        </a>
        <a href="{{ route('owner.withdrawal.create') }}" class="sidebar-link">
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
            <h1 class="text-lg font-semibold text-slate-900">Lapangan Saya</h1>
            <p class="text-xs text-slate-400 mt-0.5">Kelola semua lapangan yang Anda daftarkan</p>
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
    </main>
</div>

</div>
</body>
</html>
