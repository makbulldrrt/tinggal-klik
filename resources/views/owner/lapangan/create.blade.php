<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tambah Lapangan Baru — Tinggal Klik Owner">
    <title>Tambah Lapangan — Tinggal Klik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } };</script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.625rem; font-size:0.875rem; font-weight:500; color:#94a3b8; transition:background 0.15s,color 0.15s; }
        .sidebar-link:hover { background:rgba(255,255,255,0.06); color:#f1f5f9; }
        .sidebar-link.active { background:rgba(16,185,129,0.15); color:#34d399; }
        .form-input { width:100%; padding:0.625rem 0.875rem; border-radius:0.625rem; border:1px solid #e2e8f0; font-size:0.875rem; transition:border-color 0.15s,box-shadow 0.15s; background:#fff; outline:none; }
        .form-input:focus { border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
        .form-label { display:block; font-size:0.75rem; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.375rem; }
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
        <a href="{{ route('owner.dashboard') }}" class="sidebar-link">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
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
    <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center gap-4 flex-shrink-0">
        <a href="{{ route('owner.lapangan.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-slate-900">Tambah Lapangan Baru</h1>
            <p class="text-xs text-slate-400 mt-0.5">Daftarkan lapangan baru ke dalam sistem</p>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto px-8 py-7">
        <div class="max-w-2xl">

            @if($errors->any())
            <div id="alert-errors" class="flex items-start gap-3 p-4 mb-6 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form id="form-lapangan" method="POST" action="{{ route('owner.lapangan.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
                @csrf

                <div>
                    <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
                    <input type="text" id="nama_lapangan" name="nama_lapangan" value="{{ old('nama_lapangan') }}" class="form-input" placeholder="Contoh: Lapangan Futsal Merdeka" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_olahraga" class="form-label">Jenis Olahraga</label>
                        <select id="jenis_olahraga" name="jenis_olahraga" class="form-input">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach(['Futsal','Badminton','Basket','Tennis','Voli','Renang','Golf','Lainnya'] as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_olahraga') === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="harga_per_jam" class="form-label">Harga per Jam (Rp)</label>
                        <input type="number" id="harga_per_jam" name="harga_per_jam" value="{{ old('harga_per_jam') }}" class="form-input" placeholder="50000" min="1" required>
                    </div>
                </div>

                <div>
                    <label for="alamat_teks" class="form-label">Alamat Jalan</label>
                    <input type="text" id="alamat_teks" class="form-input mb-3" placeholder="Contoh: Jl. Merdeka No.1, Jakarta Selatan" value="{{ old('alamat_teks', explode('|', old('lokasi', ''))[0] ?? '') }}">

                    <label for="koordinat_gmaps" class="form-label">Koordinat Google Maps</label>
                    <input type="text" id="koordinat_gmaps" class="form-input mb-1" placeholder="Contoh: -6.2088,106.8456" autocomplete="off">
                    <p class="text-xs text-slate-400 mb-2">Buka Google Maps → klik lokasi → salin koordinat → tempelkan di sini.</p>

                    <div id="map" style="height:300px;width:100%;margin-top:10px;z-index:1;border-radius:8px;border:1px solid #e2e8f0;"></div>
                    <input type="hidden" id="lokasi" name="lokasi" value="{{ old('lokasi') }}">
                </div>

                <div>
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="form-input resize-none" placeholder="Jelaskan fasilitas dan kondisi lapangan..." required>{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label for="foto_lapangan" class="form-label">Foto Lapangan</label>
                    <input type="file" id="foto_lapangan" name="foto_lapangan" accept="image/jpg,image/jpeg,image/png,image/webp" class="form-input p-2 cursor-pointer">
                    <p class="text-xs text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</p>
                </div>

                <div>
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-input" required>
                        <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="pemeliharaan" {{ old('status') === 'pemeliharaan' ? 'selected' : '' }}>Pemeliharaan</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('owner.lapangan.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</a>
                    <button type="submit" id="btn-simpan-lapangan" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 transition-all shadow-sm">
                        Simpan Lapangan
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    var defaultLat = -6.2088;
    var defaultLng = 106.8456;
    var defaultZoom = 13;

    var redIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        shadowSize: [41, 41]
    });

    var map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    var marker = L.marker([defaultLat, defaultLng], { icon: redIcon }).addTo(map);

    var koordinatInput = document.getElementById('koordinat_gmaps');
    var lokasiHidden   = document.getElementById('lokasi');
    var alamatInput    = document.getElementById('alamat_teks');

    function convertDMSToDecimal(dmsStr) {
        var matches = dmsStr.match(/(\d+(?:\.\d+)?)[^\dA-Za-z]*(\d+(?:\.\d+)?)[^\dA-Za-z]*(\d+(?:\.\d+)?)[^\dA-Za-z]*([NSEWnsew])/g);
        if (!matches || matches.length !== 2) return null;
        function parseDMS(str) {
            var m = str.match(/(\d+(?:\.\d+)?)[^\dA-Za-z]*(\d+(?:\.\d+)?)[^\dA-Za-z]*(\d+(?:\.\d+)?)[^\dA-Za-z]*([NSEWnsew])/i);
            if (!m) return null;
            var dec = parseFloat(m[1]) + (parseFloat(m[2]) / 60) + (parseFloat(m[3]) / 3600);
            var dir = m[4].toUpperCase();
            if (dir === 'S' || dir === 'W') dec *= -1;
            return dec;
        }
        var lat = parseDMS(matches[0]);
        var lng = parseDMS(matches[1]);
        if (lat === null || lng === null) return null;
        return { lat: lat, lng: lng };
    }

    function updateMarkerFromInput() {
        var val = koordinatInput.value.trim();
        if (!val) return;

        if (/[°'"NSEWnsew]/.test(val)) {
            var decCoords = convertDMSToDecimal(val);
            if (decCoords) {
                val = decCoords.lat.toFixed(6) + ', ' + decCoords.lng.toFixed(6);
                koordinatInput.value = val;
            }
        }

        var parts = val.split(',');
        if (parts.length < 2) return;
        var lat = parseFloat(parts[0].trim());
        var lng = parseFloat(parts[1].trim());
        if (isNaN(lat) || isNaN(lng)) return;
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 16);
    }

    koordinatInput.addEventListener('input',  updateMarkerFromInput);
    koordinatInput.addEventListener('paste', function () {
        setTimeout(updateMarkerFromInput, 50);
    });

    document.getElementById('form-lapangan').addEventListener('submit', function () {
        lokasiHidden.value = alamatInput.value.trim() + '|' + koordinatInput.value.trim();
    });
}());
</script>
</html>
