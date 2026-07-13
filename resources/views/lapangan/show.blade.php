@extends('layouts.app')

@section('content')

@php
    $lokasiRaw   = $lapangan->lokasi ?? '';
    $parts       = explode('|', $lokasiRaw);
    $lokasiTeks  = trim($parts[0] ?? $lokasiRaw);
    $koordinat   = trim($parts[1] ?? '');
    $coords      = $koordinat ? explode(',', $koordinat) : [];
    $lat         = isset($coords[0]) && $coords[0] !== '' ? (float) $coords[0] : null;
    $lng         = isset($coords[1]) && $coords[1] !== '' ? (float) $coords[1] : null;
    $hasCoords   = ($lat !== null && $lng !== null && ($lat != 0 || $lng != 0));

    $sportKey  = strtolower(trim($lapangan->jenis_olahraga ?? ''));
    $sportMeta = [
        'futsal'    => ['icon' => 'sports_soccer',    'bg' => '#dfe8ff', 'fg' => '#00458e'],
        'badminton' => ['icon' => 'sports_tennis',    'bg' => '#d3e3ff', 'fg' => '#004882'],
        'basket'    => ['icon' => 'sports_basketball','bg' => '#fde8d3', 'fg' => '#7a3000'],
        'tennis'    => ['icon' => 'sports_tennis',    'bg' => '#d2f4e4', 'fg' => '#005230'],
        'voli'      => ['icon' => 'sports_volleyball','bg' => '#ecdeff', 'fg' => '#4b0082'],
    ];
    $meta        = $sportMeta[$sportKey] ?? ['icon' => 'sports', 'bg' => '#eeeef0', 'fg' => '#414753'];
    $isAvailable = strtolower($lapangan->status ?? '') === 'tersedia';
    $imgSrc      = !empty($lapangan->foto_lapangan) ? asset('storage/' . $lapangan->foto_lapangan) : null;
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    .detail-hero-img {
        width: 100%;
        height: 380px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }
    .detail-hero-placeholder {
        width: 100%;
        height: 380px;
        border-radius: 20px;
        background: linear-gradient(135deg, #eeeef0 0%, #e2e2e4 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        color: #9fa3ae;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    }
    .detail-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-pill.tersedia     { background: rgba(26,127,69,.12); color: #1a7f45; border: 1px solid rgba(26,127,69,.25); }
    .status-pill.pemeliharaan { background: rgba(186,26,26,.10); color: #ba1a1a; border: 1px solid rgba(186,26,26,.20); }
    .detail-price {
        font-size: 32px;
        font-weight: 800;
        color: #004e9f;
        line-height: 1;
    }
    .btn-booking-main {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px 24px;
        border-radius: 16px;
        font-size: 17px;
        font-weight: 700;
        font-family: 'Inter', system-ui, sans-serif;
        text-decoration: none;
        background: linear-gradient(135deg, #004e9f 0%, #0066cc 100%);
        color: #ffffff;
        box-shadow: 0 6px 24px rgba(0, 78, 159, 0.35);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .btn-booking-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 32px rgba(0, 78, 159, 0.45);
        color: #ffffff;
        text-decoration: none;
    }
    .btn-booking-main:active { transform: translateY(0); }
    .btn-booking-disabled {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px 24px;
        border-radius: 16px;
        font-size: 17px;
        font-weight: 700;
        font-family: 'Inter', system-ui, sans-serif;
        background: #c8c6c8;
        color: #ffffff;
        cursor: not-allowed;
    }
    .info-card {
        background: #ffffff;
        border: 1px solid #e8e8ea;
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .map-hint-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        color: #92400e;
        margin-bottom: 10px;
        cursor: pointer;
        transition: background .2s;
    }
    .map-hint-bar:hover { background: #fef3c7; }
</style>

<div style="font-family:'Inter',system-ui,sans-serif;">

    <div class="flex items-center gap-2 mb-5 text-sm text-outline">
        <a href="{{ route('lapangan.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
            Kembali ke Katalog
        </a>
        <span class="material-symbols-outlined" style="font-size:14px;color:#c1c6d5;">chevron_right</span>
        <span class="text-on-surface font-medium truncate">{{ $lapangan->nama_lapangan }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 flex flex-col gap-5">

            <div>
                @if($imgSrc)
                    <img src="{{ $imgSrc }}" alt="{{ $lapangan->nama_lapangan }}"
                         class="detail-hero-img"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="detail-hero-placeholder" style="display:none;">
                        <span class="material-symbols-outlined" style="font-size:60px;opacity:.4;">{{ $meta['icon'] }}</span>
                        <span style="font-size:14px;">Foto tidak tersedia</span>
                    </div>
                @else
                    <div class="detail-hero-placeholder">
                        <span class="material-symbols-outlined" style="font-size:60px;opacity:.4;">{{ $meta['icon'] }}</span>
                        <span style="font-size:14px;">{{ $lapangan->nama_lapangan }}</span>
                    </div>
                @endif
            </div>

            <div class="info-card">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <h1 style="font-size:24px;font-weight:800;color:#1a1c1d;line-height:1.2;margin-bottom:8px;">
                            {{ $lapangan->nama_lapangan }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="detail-badge" style="background:{{ $meta['bg'] }};color:{{ $meta['fg'] }};">
                                <span class="material-symbols-outlined" style="font-size:15px;font-variation-settings:'FILL' 1;">{{ $meta['icon'] }}</span>
                                {{ $lapangan->jenis_olahraga }}
                            </span>
                            <span class="status-pill {{ strtolower($lapangan->status ?? 'pemeliharaan') }}">
                                <span class="material-symbols-outlined" style="font-size:13px;font-variation-settings:'FILL' 1;">
                                    {{ $isAvailable ? 'check_circle' : 'cancel' }}
                                </span>
                                {{ $isAvailable ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>
                    @if($lapangan->owner)
                    <div class="text-right text-sm text-outline shrink-0">
                        <span class="material-symbols-outlined" style="font-size:14px;vertical-align:-2px;">person</span>
                        {{ $lapangan->owner->name }}
                    </div>
                    @endif
                </div>

                @if($lapangan->deskripsi)
                <div class="border-t border-hairline pt-4">
                    <p style="font-size:13px;font-weight:600;color:#727784;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Deskripsi</p>
                    <p style="font-size:15px;color:#414753;line-height:1.7;">{{ $lapangan->deskripsi }}</p>
                </div>
                @endif

                @if($lokasiTeks)
                <div class="border-t border-hairline pt-4 mt-4 flex items-start gap-2">
                    <span class="material-symbols-outlined text-primary shrink-0" style="font-size:18px;margin-top:1px;font-variation-settings:'FILL' 0;">location_on</span>
                    <p style="font-size:14px;color:#414753;line-height:1.5;">{{ $lokasiTeks }}</p>
                </div>
                @endif
            </div>

            <div class="info-card">
                <p style="font-size:13px;font-weight:600;color:#727784;text-transform:uppercase;letter-spacing:.05em;margin-bottom:14px;">Lokasi di Peta</p>

                @if($hasCoords)
                    <div class="map-hint-bar" id="map-hint-btn">
                        📍 Klik peta untuk membuka rute dan navigasi di Google Maps
                    </div>
                    <div id="detail-map" style="height:350px;width:100%;z-index:1;border-radius:8px;cursor:pointer;border:1px solid #e0e0e0;"></div>
                @else
                    <div style="height:180px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;color:#9fa3ae;background:#f5f5f7;border-radius:12px;">
                        <span class="material-symbols-outlined" style="font-size:44px;opacity:.4;">map</span>
                        <span style="font-size:13px;">Koordinat belum tersedia untuk lapangan ini.</span>
                    </div>
                @endif
            </div>

        </div>

        <div class="flex flex-col gap-4">

            <div class="info-card sticky top-24">
                <p style="font-size:12px;color:#9fa3ae;margin-bottom:4px;">Harga mulai dari</p>
                <div class="flex items-baseline gap-1 mb-1">
                    <span class="detail-price">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</span>
                    <span style="font-size:13px;color:#9fa3ae;font-weight:400;">/ jam</span>
                </div>

                <div class="border-t border-hairline my-4"></div>

                <div class="flex flex-col gap-2 mb-5 text-sm text-outline">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined shrink-0" style="font-size:16px;font-variation-settings:'FILL' 0;">sports</span>
                        <span>{{ $lapangan->jenis_olahraga }}</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined shrink-0" style="font-size:16px;font-variation-settings:'FILL' 0;">location_on</span>
                        <span>{{ $lokasiTeks ?: 'Lokasi belum diatur' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined shrink-0" style="font-size:16px;font-variation-settings:'FILL' 1;">{{ $isAvailable ? 'check_circle' : 'cancel' }}</span>
                        <span>{{ $isAvailable ? 'Tersedia untuk dipesan' : 'Sedang dalam pemeliharaan' }}</span>
                    </div>
                </div>

                @if($isAvailable)
                    <a href="{{ route('booking.create', $lapangan->id) }}"
                       id="btn-booking-lapangan"
                       class="btn-booking-main">
                        <span class="material-symbols-outlined" style="font-size:22px;font-variation-settings:'FILL' 1;">event_available</span>
                        Booking Lapangan Sekarang
                    </a>
                @else
                    <div class="btn-booking-disabled">
                        <span class="material-symbols-outlined" style="font-size:22px;font-variation-settings:'FILL' 0;">block</span>
                        Tidak Tersedia
                    </div>
                @endif

                <p style="font-size:11px;color:#9fa3ae;text-align:center;margin-top:10px;">
                    Kamu akan diarahkan ke halaman pemesanan
                </p>
            </div>

        </div>
    </div>
</div>

@if($hasCoords)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    var lat = {{ $lat }};
    var lng = {{ $lng }};

    var redIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        shadowSize: [41, 41]
    });

    var map = L.map('detail-map', {
        dragging: false,
        zoomControl: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        touchZoom: false
    }).setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    var marker = L.marker([lat, lng], { icon: redIcon }).addTo(map);

    function openGoogleMaps() {
        window.open('https://www.google.com/maps/search/?api=1&query=' + lat + ',' + lng, '_blank');
    }

    map.on('click', openGoogleMaps);
    marker.on('click', openGoogleMaps);

    var hintBtn = document.getElementById('map-hint-btn');
    if (hintBtn) {
        hintBtn.addEventListener('click', openGoogleMaps);
    }
}());
</script>
@endif

@endsection
