<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Tinggal-Klik') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        window.tailwind = {
            config: {
                darkMode: "class",
                theme: {
                    extend: {
                        "colors": {
                            "surface-variant": "#e2e2e4", "background": "#f9f9fb", "outline-variant": "#c1c6d5",
                            "on-secondary-fixed": "#1b1b1d", "secondary-fixed": "#e4e2e4", "surface": "#f9f9fb",
                            "tertiary-fixed": "#d3e3ff", "on-secondary": "#ffffff", "focus-ring": "#0071e3",
                            "hairline": "#e0e0e0", "on-background": "#1a1c1d", "divider-soft": "#f0f0f0",
                            "surface-bright": "#f9f9fb", "primary-fixed-dim": "#aac7ff", "on-tertiary": "#ffffff",
                            "on-primary": "#ffffff", "secondary-container": "#e2dfe1", "on-primary-container": "#dfe8ff",
                            "on-tertiary-fixed": "#001c39", "surface-container-high": "#e8e8ea", "error-container": "#ffdad6",
                            "on-surface-variant": "#414753", "on-tertiary-fixed-variant": "#004882", "on-secondary-fixed-variant": "#474649",
                            "tertiary": "#005292", "primary": "#004e9f", "on-surface": "#1a1c1d", "on-secondary-container": "#636264",
                            "ink-muted": "#7a7a7a", "on-tertiary-container": "#dde9ff", "tertiary-container": "#006abb",
                            "surface-tile-dark": "#272729", "surface-container-lowest": "#ffffff", "surface-pearl": "#fafafc",
                            "secondary": "#5f5e60", "inverse-surface": "#2f3132", "outline": "#727784", "on-error-container": "#93000a",
                            "secondary-fixed-dim": "#c8c6c8", "inverse-on-surface": "#f0f0f2", "on-error": "#ffffff",
                            "on-primary-fixed": "#001b3e", "surface-container-low": "#f3f3f5", "primary-container": "#0066cc",
                            "primary-fixed": "#d7e3ff", "surface-tint": "#005cba", "tertiary-fixed-dim": "#a3c9ff",
                            "error": "#ba1a1a", "surface-dim": "#d9dadc", "inverse-primary": "#aac7ff",
                            "surface-container-highest": "#e2e2e4", "on-primary-fixed-variant": "#00458e", "surface-container": "#eeeef0"
                        },
                        "borderRadius": { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                        "spacing": { "base": "8px", "container-max": "1440px", "gutter": "24px", "section-v": "80px", "margin-desktop": "32px", "margin-mobile": "16px" }
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #f5f5f7; }
        .glass-header { background: rgba(249, 249, 251, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .card-shadow { box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            font-size: 0.875rem; font-weight: 500;
            color: #474649;
            transition: background 0.15s, color 0.15s, transform 0.15s;
            text-decoration: none; border-left: 3px solid transparent;
        }
        .nav-link:hover { background: rgba(0,78,159,0.07); color: #004e9f; transform: translateX(2px); }
        .nav-link.active { background: #dfe8ff; color: #004e9f; border-left-color: #004e9f; font-weight: 600; }
        .nav-section-label {
            font-size: 0.65rem; font-weight: 700; color: #9fa3ae;
            text-transform: uppercase; letter-spacing: 0.08em;
            padding: 0 12px; margin: 16px 0 4px;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased text-on-surface min-h-screen flex">

    <nav class="hidden md:flex flex-col h-screen w-64 bg-white border-r border-hairline py-5 px-3 sticky top-0 z-40 shrink-0 shadow-sm">
        <div class="flex items-center gap-3 px-3 mb-6">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shrink-0 shadow">
                <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings:'FILL' 1;">stadium</span>
            </div>
            <div>
                <h2 class="text-[15px] leading-tight font-bold text-primary">Tinggal-Klik</h2>
                <p class="text-[11px] text-outline mt-0.5">Marketplace Lapangan</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto pr-1 space-y-0.5">
            @if(auth()->check() && auth()->user()->role !== 'pelanggan')
            <p class="nav-section-label">Manajemen</p>
            <a class="nav-link {{ request()->is('owner/lapangan') || request()->is('lapangan') ? 'active' : '' }}" href="@if(request()->is('owner/lapangan')) {{ url('/lapangan') }} @else {{ url('/owner/lapangan') }} @endif">
                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1;">dashboard</span>
                <span>Dashboard Lapangan</span>
            </a>
            @endif

            <p class="nav-section-label">Katalog</p>
            <a class="nav-link {{ request()->is('lapangan') || request()->is('lapangan/*') ? 'active' : '' }}" href="/lapangan">
                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 0;">sports_soccer</span>
                <span>Katalog Lapangan</span>
            </a>

            @if(auth()->check())
            <p class="nav-section-label">Akun Saya</p>
            <a class="nav-link {{ request()->is('booking/history') ? 'active' : '' }}" href="{{ route('booking.history') }}">
                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 0;">receipt_long</span>
                <span>Riwayat Pemesanan</span>
            </a>
            <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 0;">manage_accounts</span>
                <span>Profil Saya</span>
            </a>
            @endif
        </div>

        <div class="mt-4 pt-4 border-t border-hairline">
            @if(auth()->check())
            <div class="flex items-center gap-3 px-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-on-surface truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-outline truncate">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-full text-left text-error hover:bg-red-50 hover:text-red-700">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="nav-link">
                <span class="material-symbols-outlined text-[18px]">login</span>
                <span>Masuk</span>
            </a>
            @endif
        </div>
    </nav>

    <div class="flex-1 flex flex-col min-w-0">

        <header class="glass-header border-b border-hairline sticky top-0 z-30 h-14 px-4 md:px-8 w-full flex justify-between items-center shrink-0">
            <button id="mobileMenuBtn" class="md:hidden text-secondary p-2 -ml-2 rounded-full hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="md:hidden text-[17px] font-bold text-primary">Tinggal-Klik</div>

            <div class="flex-1 flex items-center justify-end gap-3">
                @if(auth()->check())
                <div class="hidden sm:flex items-center gap-2 text-sm text-on-surface-variant">
                    <span class="font-medium text-on-surface">{{ auth()->user()->name }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-semibold">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-primary hover:underline">Masuk</a>
                @endif
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="max-w-[1440px] mx-auto">
                @yield('content')
            </div>
        </main>

        <footer class="border-t border-hairline bg-white py-4 px-8 text-center">
            <p class="text-sm text-gray-400">© 2026 Tinggal-Klik Marketplace. Semua Hak Dilindungi.</p>
        </footer>
    </div>

    <div id="mobileSidebarOverlay" class="fixed inset-0 bg-on-background/50 backdrop-blur-sm z-[60] hidden transition-opacity">
        <aside id="mobileSidebar" class="absolute left-0 top-0 bottom-0 w-64 bg-white flex flex-col py-5 px-3 transform -translate-x-full transition-transform duration-300 ease-in-out shadow-xl">
            <div class="flex justify-between items-center px-3 mb-5">
                <h2 class="font-bold text-on-surface text-sm">Menu Navigasi</h2>
                <button id="closeMobileMenuBtn" class="p-1.5 rounded-full hover:bg-surface-container-low text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto space-y-0.5">
                @if(auth()->check() && auth()->user()->role !== 'pelanggan')
                <a class="nav-link {{ request()->is('owner/lapangan') || request()->is('lapangan') ? 'active' : '' }}" href="@if(request()->is('owner/lapangan')) {{ url('/lapangan') }} @else {{ url('/owner/lapangan') }} @endif">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1;">dashboard</span>
                    <span>Dashboard Lapangan</span>
                </a>
                @endif
                <a class="nav-link {{ request()->is('lapangan') || request()->is('lapangan/*') ? 'active' : '' }}" href="/lapangan">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 0;">sports_soccer</span>
                    <span>Katalog Lapangan</span>
                </a>
                @if(auth()->check())
                <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 0;">manage_accounts</span>
                    <span>Profil Saya</span>
                </a>
                @endif
            </nav>
            @if(auth()->check())
            <div class="mt-4 pt-4 border-t border-hairline">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-full text-left text-error hover:bg-red-50">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
            @endif
        </aside>
    </div>

    <script>
    (function () {
        var mobileMenuBtn     = document.getElementById('mobileMenuBtn');
        var closeMobileMenuBtn = document.getElementById('closeMobileMenuBtn');
        var overlay           = document.getElementById('mobileSidebarOverlay');
        var sidebar           = document.getElementById('mobileSidebar');

        function toggleMenu() {
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(function () { sidebar.classList.remove('-translate-x-full'); }, 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                setTimeout(function () { overlay.classList.add('hidden'); }, 300);
            }
        }

        if (mobileMenuBtn)      mobileMenuBtn.addEventListener('click', toggleMenu);
        if (closeMobileMenuBtn) closeMobileMenuBtn.addEventListener('click', toggleMenu);
        if (overlay)            overlay.addEventListener('click', function (e) { if (e.target === overlay) toggleMenu(); });
    }());
    </script>
    @stack('scripts')
</body>
</html>