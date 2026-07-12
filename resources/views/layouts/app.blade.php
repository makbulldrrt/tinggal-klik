<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Token Keamanan Laravel (Penting!) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tinggal-Klik Admin') }}</title>

    <!-- Google Material Symbols & Fonts bawaan dari Stitch -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>

    <!-- Load CSS/JS bawaan Laravel (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inject Konfigurasi Warna Khusus Google Stitch agar tidak tabrakan -->
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
        body { background-color: #f5f5f7; }
        .glass-header { background: rgba(249, 249, 251, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .card-shadow { box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px; }
        .image-shadow { box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 20px; }
    </style>
</head>
<body class="font-sans antialiased text-on-surface min-h-screen flex">

    <!-- 1. SIDEBAR DESKTOP (Kustom Stitch) -->
    <nav class="hidden md:flex flex-col h-screen w-72 bg-surface-container-low border-r border-hairline py-6 px-4 gap-y-2 sticky top-0 z-40 shrink-0">
        <div class="flex items-center gap-3 px-3 mb-8">
            <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-on-primary-container" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
            </div>
            <div>
                <h2 class="font-headline-md text-[20px] leading-tight font-bold text-primary">Tinggal-Klik Admin</h2>
                <p class="font-label-sm text-label-sm text-on-surface-variant mt-0.5">Multi-Role Dashboard</p>
            </div>
        </div>

        <!-- Links Menu Navigasi -->
        <div class="flex-1 space-y-1 overflow-y-auto pr-1">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-md bg-primary-fixed text-on-primary-fixed border-l-4 border-primary font-semibold transition-all duration-200" href="#">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span class="text-sm">Financial Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-md text-on-secondary-fixed-variant hover:bg-surface-variant/50 hover:translate-x-1 transition-all duration-200 border-l-4 border-transparent" href="#">
                <span class="material-symbols-outlined">sports_tennis</span>
                <span class="text-sm">Court Catalog</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-md text-on-secondary-fixed-variant hover:bg-surface-variant/50 hover:translate-x-1 transition-all duration-200 border-l-4 border-transparent" href="#">
                <span class="material-symbols-outlined">history</span>
                <span class="text-sm">Booking History</span>
            </a>
        </div>

        <!-- Footer Sidebar (Logout) -->
        <div class="mt-auto pt-4 border-t border-hairline space-y-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-error hover:bg-error-container/50 transition-colors text-left">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-semibold">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- 2. WRAPPER UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- TOP APP BAR / HEADER -->
        <header class="glass-header border-b border-hairline sticky top-0 z-30 h-16 px-margin-mobile md:px-margin-desktop w-full flex justify-between items-center shrink-0">
            <button id="mobileMenuBtn" class="md:hidden text-secondary p-2 -ml-2 rounded-full hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="md:hidden font-headline-md text-[20px] font-bold text-primary">Tinggal-Klik</div>
            
            <div class="flex-1 flex items-center justify-end gap-4">
                <div class="hidden md:flex relative w-64">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input class="w-full bg-surface-container-lowest border border-hairline rounded-full py-1.5 pl-10 pr-4 text-sm focus:outline-none focus:border-focus-ring focus:ring-1" placeholder="Search dashboard..." type="text"/>
                </div>
                <!-- Informasi User Login -->
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline">{{ Auth::user()->name ?? 'User' }}</span>
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- KONTEN DINAMIS (DIISI OLEH VIEW HALAMAN LAIN) -->
        <main class="flex-1 overflow-y-auto p-margin-mobile md:p-margin-desktop">
            <div class="max-w-container-max mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- 3. MOBILE SIDEBAR OVERLAY -->
    <div id="mobileSidebarOverlay" class="fixed inset-0 bg-on-background/50 backdrop-blur-sm z-[60] hidden transition-opacity">
        <aside id="mobileSidebar" class="absolute left-0 top-0 bottom-0 w-72 bg-surface flex flex-col py-6 px-4 transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="flex justify-between items-center px-4 mb-6">
                <h2 class="font-label-lg text-label-lg text-on-surface font-bold">Menu Navigasi</h2>
                <button id="closeMobileMenuBtn" class="p-2 rounded-full hover:bg-surface-container-low text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-primary-fixed text-on-primary-fixed border-l-4 border-primary font-semibold" href="#">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Financial Dashboard</span>
                </a>
            </nav>
        </aside>
    </div>

    <!-- Logic Script Menu Mobile Interaktif -->
    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMobileMenuBtn = document.getElementById('closeMobileMenuBtn');
        const overlay = document.getElementById('mobileSidebarOverlay');
        const sidebar = document.getElementById('mobileSidebar');

        function toggleMenu() {
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => sidebar.classList.remove('-translate-x-full'), 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        if(mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleMenu);
        if(closeMobileMenuBtn) closeMobileMenuBtn.addEventListener('click', toggleMenu);
        if(overlay) overlay.addEventListener('click', (e) => { if (e.target === overlay) toggleMenu(); });
    </script>
</body>
</html>