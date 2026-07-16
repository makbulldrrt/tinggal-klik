<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Tinggal Klik</title>
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
    @include('admin.partials.sidebar')
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-lg font-semibold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>
        <main class="flex-1 overflow-y-auto px-8 py-7">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
