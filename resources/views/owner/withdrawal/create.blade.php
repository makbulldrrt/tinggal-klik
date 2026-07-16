<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Finansial Owner — Tinggal Klik">
    <title>Finansial — Tinggal Klik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } };</script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.625rem; font-size:0.875rem; font-weight:500; color:#94a3b8; transition:background 0.15s,color 0.15s; }
        .sidebar-link:hover { background:rgba(255,255,255,0.06); color:#f1f5f9; }
        .sidebar-link.active { background:rgba(16,185,129,0.15); color:#34d399; }
        .stat-card { transition:transform 0.2s ease,box-shadow 0.2s ease; }
        .stat-card:hover { transform:translateY(-3px); box-shadow:0 20px 40px rgba(0,0,0,0.10); }
        .form-input { width:100%; padding:0.625rem 0.875rem; border-radius:0.625rem; border:1px solid #e2e8f0; font-size:0.875rem; transition:border-color 0.15s,box-shadow 0.15s; background:#fff; outline:none; }
        .form-input:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
        .form-label { display:block; font-size:0.75rem; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.375rem; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
<div class="flex h-screen overflow-hidden">

@include('owner.partials.sidebar')

<div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center gap-4 flex-shrink-0">
        <a href="{{ route('lapangan.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-slate-900">Finansial</h1>
            <p class="text-xs text-slate-400 mt-0.5">Kelola keuangan dan ajukan penarikan saldo</p>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-8 py-7">
        <div class="max-w-5xl space-y-7">

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
                            <span class="text-xs text-sky-600 font-medium">Siap untuk ditarik</span>
                            @else
                            <span class="text-xs text-slate-400 font-medium">Belum ada saldo</span>
                            @endif
                        </div>
                    </div>

                </div>
            </section>

            <div class="max-w-2xl flex items-center gap-3 p-4 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 text-sm font-medium">
                <svg class="w-5 h-5 text-sky-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Setiap transaksi dikenakan biaya admin platform sebesar 2%.</span>
            </div>

            @if($saldoTersedia < 10000 && $saldoTersedia > 0)
            <div id="alert-minimum-saldo" class="max-w-2xl flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Minimum penarikan saldo adalah Rp 10.000. Saldo Anda saat ini belum mencukupi.</span>
            </div>
            @endif

            @if($errors->any())
            <div id="alert-errors" class="max-w-2xl flex items-start gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <p class="font-semibold mb-1">Validasi gagal:</p>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @if($saldoTersedia >= 10000)
            <form method="POST" action="{{ route('owner.withdrawal.store') }}" class="max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
                @csrf

                <div>
                    <label for="jumlah_penarikan" class="form-label">Jumlah Penarikan (Rp)</label>
                    <input type="number" id="jumlah_penarikan" name="jumlah_penarikan" value="{{ old('jumlah_penarikan') }}" class="form-input" min="10000" max="{{ $saldoTersedia }}" placeholder="Contoh: 100000" required>
                    <p class="text-xs text-slate-400 mt-1">Minimum penarikan: Rp 10.000 · Maksimum: Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</p>
                </div>

                <div>
                    <label for="bank_tujuan" class="form-label">Bank Tujuan</label>
                    <select id="bank_tujuan" name="bank_tujuan" class="form-input" required>
                        <option value="">-- Pilih Bank --</option>
                        @foreach(['BCA','BNI','BRI','Mandiri','CIMB Niaga','Danamon','Permata Bank','BSI','Bank Jago','Jenius'] as $bank)
                        <option value="{{ $bank }}" {{ old('bank_tujuan') === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                    <input type="text" id="nomor_rekening" name="nomor_rekening" value="{{ old('nomor_rekening') }}" class="form-input" placeholder="Contoh: 1234567890" maxlength="50" required>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p>Permintaan penarikan akan diproses oleh admin dalam 1–3 hari kerja. Pastikan data rekening yang Anda masukkan sudah benar.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('lapangan.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
                    <button type="submit" id="btn-ajukan-penarikan" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 transition-all shadow-sm">
                        Ajukan Penarikan
                    </button>
                </div>
            </form>
            @else
            <div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <p class="text-slate-600 font-medium">Saldo tidak mencukupi</p>
                <p class="text-sm text-slate-400 mt-1">Minimum penarikan adalah Rp 10.000. Tunggu hingga ada transaksi yang masuk.</p>
                <a href="{{ route('lapangan.index') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                    Kembali ke Dashboard Lapangan
                </a>
            </div>
            @endif

        </div>
    </main>
</div>

</div>
</body>
</html>
