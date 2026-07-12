@extends('layouts.app')

@section('content')

{{-- ============================================================
     PAGE: Court Catalog — resources/views/lapangan/index.blade.php
     PJ   : Mahdi | Sprint: Langkah 3 (Hari 2)
     Extends layouts.app — DO NOT add <html>/<body> tags here.
     All colours reference the M3 tokens injected in app.blade.php.
     ============================================================ --}}

<style>
    /* ── Catalog-scoped styles ── */

    /* Hero gradient banner */
    .catalog-hero {
        background: linear-gradient(135deg, #004e9f 0%, #0066cc 50%, #005292 100%);
        position: relative;
        overflow: hidden;
    }
    .catalog-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .catalog-hero::after {
        content: '';
        position: absolute;
        bottom: -2px; left: 0; right: 0;
        height: 40px;
        background: #f5f5f7;
        clip-path: ellipse(55% 100% at 50% 100%);
    }

    /* Search input */
    .search-wrap { position: relative; }
    .search-wrap .search-icon {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: #727784; font-size: 20px; pointer-events: none;
    }
    .search-input {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #e0e0e0;
        border-radius: 9999px;
        padding: 11px 18px 11px 46px;
        font-size: 14px;
        color: #1a1c1d;
        font-family: 'Inter', system-ui, sans-serif;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .search-input::placeholder { color: #9fa3ae; }
    .search-input:focus {
        border-color: #004e9f;
        box-shadow: 0 0 0 3px rgba(0, 78, 159, 0.12);
    }

    /* Filter chips */
    .filter-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px;
        border-radius: 9999px;
        font-size: 13px; font-weight: 500;
        font-family: 'Inter', system-ui, sans-serif;
        cursor: pointer;
        border: 1.5px solid #e0e0e0;
        background: #ffffff;
        color: #414753;
        transition: all .2s ease;
        white-space: nowrap;
        user-select: none;
        text-decoration: none;
    }
    .filter-chip:hover {
        border-color: #004e9f;
        color: #004e9f;
        background: #f0f5ff;
        text-decoration: none;
    }
    .filter-chip.active {
        background: #004e9f;
        border-color: #004e9f;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 78, 159, 0.30);
    }
    .filter-chip .chip-icon { font-size: 15px; line-height: 1; }

    /* Court card */
    .court-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e8e8ea;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
        display: flex; flex-direction: column;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .court-card:hover {
        transform: translateY(-4px);
        box-shadow: rgba(0, 0, 0, 0.12) 0px 12px 32px;
    }

    /* Image area — 16:9 */
    .court-card-img-wrap {
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        overflow: hidden;
        background: #eeeef0;
    }
    .court-card-img-wrap img,
    .court-card-img-wrap .img-placeholder {
        position: absolute;
        inset: 0; width: 100%; height: 100%;
        object-fit: cover;
    }
    .court-card-img-wrap .img-placeholder {
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 8px;
        background: linear-gradient(135deg, #eeeef0 0%, #e2e2e4 100%);
        color: #9fa3ae;
    }
    .court-card-img-wrap .img-placeholder .ph-icon { font-size: 44px; opacity: .5; }
    .court-card-img-wrap .img-placeholder p { font-size: 12px; color: #9fa3ae; margin: 0; text-align:center; padding:0 8px; }

    /* Status badge */
    .status-badge {
        position: absolute; top: 12px; right: 12px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px; font-weight: 600; letter-spacing: .3px;
        backdrop-filter: blur(8px);
    }
    .status-badge.tersedia     { background: rgba(26,127,69,.85);  color: #fff; }
    .status-badge.tidak        { background: rgba(186,26,26,.80);  color: #fff; }
    .status-badge.pemeliharaan { background: rgba(186,26,26,.80);  color: #fff; }

    /* Category chip on image */
    .category-chip-img {
        position: absolute; top: 12px; left: 12px;
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px 4px 8px;
        border-radius: 9999px;
        font-size: 11px; font-weight: 600; letter-spacing: .3px;
        backdrop-filter: blur(8px);
        color: #ffffff;
    }
    .category-chip-img.futsal    { background: rgba(0,78,159,.80); }
    .category-chip-img.badminton { background: rgba(0,82,146,.75); }
    .category-chip-img.basket    { background: rgba(174,85,0,.80); }
    .category-chip-img.tennis    { background: rgba(10,115,60,.80); }
    .category-chip-img.voli      { background: rgba(109,0,186,.75); }
    .category-chip-img.default   { background: rgba(65,71,83,.80); }

    /* Card body */
    .court-card-body { padding: 16px 18px 18px; flex: 1; display: flex; flex-direction: column; gap: 6px; }

    .court-name {
        font-size: 16px; font-weight: 700;
        color: #1a1c1d; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }

    .court-location {
        display: flex; align-items: center; gap: 4px;
        font-size: 12px; color: #727784;
    }
    .court-location .material-symbols-outlined { font-size: 15px; }

    .court-sport-label {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 11px; font-weight: 600;
        margin-top: 2px;
        width: fit-content;
    }
    .court-sport-label .material-symbols-outlined { font-size: 13px; }

    /* Star rating */
    .star-rating { display: flex; align-items: center; gap: 4px; margin-top: 2px; }
    .star-rating .stars { color: #f5a623; font-size: 13px; letter-spacing: 1px; }
    .star-rating .rating-text { font-size: 12px; color: #727784; }

    /* Price + CTA row */
    .court-price-row {
        display: flex; align-items: flex-end; justify-content: space-between;
        margin-top: auto; padding-top: 12px;
        border-top: 1px solid #f0f0f0;
    }
    .court-price-label  { font-size: 11px; color: #9fa3ae; line-height: 1.2; }
    .court-price-value  { font-size: 20px; font-weight: 700; color: #004e9f; line-height: 1.1; }
    .court-price-unit   { font-size: 11px; color: #9fa3ae; font-weight: 400; }

    /* Pesan Sekarang button */
    .btn-pesan {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        width: 100%; margin-top: 12px;
        background: #004e9f;
        color: #ffffff;
        font-size: 14px; font-weight: 600;
        font-family: 'Inter', system-ui, sans-serif;
        padding: 11px 20px;
        border-radius: 9999px;
        border: none; cursor: pointer;
        text-decoration: none;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 2px 8px rgba(0, 78, 159, 0.25);
    }
    .btn-pesan:hover {
        background: #003e80;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 78, 159, 0.35);
        color: #ffffff;
        text-decoration: none;
    }
    .btn-pesan:active { transform: translateY(0); }
    .btn-pesan.disabled {
        background: #c8c6c8; box-shadow: none;
        cursor: not-allowed; pointer-events: none;
        color: #ffffff;
    }
    .btn-pesan .material-symbols-outlined { font-size: 17px; }

    /* Empty state */
    .empty-state {
        text-align: center; padding: 72px 24px;
        background: #ffffff; border-radius: 16px;
        border: 1.5px dashed #c1c6d5;
    }
    .empty-state .empty-icon { font-size: 64px; color: #c1c6d5; display: block; margin-bottom: 16px; }
    .empty-state h3 { font-size: 18px; font-weight: 700; color: #1a1c1d; margin: 0 0 8px; }
    .empty-state p  { font-size: 14px; color: #727784; margin: 0; }

    /* Results count pill */
    .results-count {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 14px;
        background: #dfe8ff; color: #00458e;
        border-radius: 9999px; font-size: 12px; font-weight: 600;
    }

    /* Pagination */
    .pagination-outer { margin-top: 36px; }
    .pagination-outer nav { display: flex; justify-content: center; flex-wrap: wrap; gap: 4px; }
    .pagination-outer span[aria-disabled="true"] > span,
    .pagination-outer a {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 36px; height: 36px; padding: 0 12px;
        border-radius: 9999px;
        font-size: 13px; font-weight: 500;
        border: 1.5px solid #e0e0e0;
        background: #ffffff; color: #414753;
        text-decoration: none;
        transition: all .15s ease;
    }
    .pagination-outer a:hover {
        border-color: #004e9f; color: #004e9f; background: #f0f5ff;
    }
    .pagination-outer span[aria-current="page"] > span {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 36px; height: 36px; padding: 0 12px;
        border-radius: 9999px;
        font-size: 13px; font-weight: 700;
        background: #004e9f; color: #ffffff;
        border: 1.5px solid #004e9f;
    }
    .pagination-outer span[aria-disabled="true"] > span { color: #c1c6d5; cursor: default; }
</style>

{{-- ── HERO BANNER ── --}}
<div class="catalog-hero rounded-2xl mb-6 px-6 py-8 md:px-10 md:py-10">
    <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3 text-white/70 text-xs">
            <span class="material-symbols-outlined" style="font-size:14px;">home</span>
            <span>/</span>
            <span class="text-white font-medium">Katalog Lapangan</span>
        </div>
        <h1 class="text-white font-bold mb-1" style="font-size:clamp(22px,4vw,30px);line-height:1.2;font-family:'Inter',system-ui,sans-serif;">
            Temukan Lapangan Olahraga Terbaik
        </h1>
        <p class="text-white/75 text-sm mb-5 max-w-lg" style="font-family:'Inter',system-ui,sans-serif;">
            Booking lapangan Futsal, Badminton, Basket &amp; lebih banyak lagi — langsung, mudah, tanpa ribet.
        </p>
        <form method="GET" action="{{ request()->url() }}" class="flex gap-2 max-w-xl">
            <div class="search-wrap flex-1">
                <span class="search-icon material-symbols-outlined">search</span>
                <input id="hero-search-input" class="search-input" type="text" name="search"
                       value="{{ request('search') }}" placeholder="Cari nama lapangan…" autocomplete="off"/>
            </div>
            @if(request('jenis') && request('jenis') !== 'semua')
                <input type="hidden" name="jenis" value="{{ request('jenis') }}">
            @endif
            <button type="submit" class="btn-pesan" style="width:auto;padding:11px 22px;margin:0;box-shadow:none;flex-shrink:0;">
                <span class="material-symbols-outlined" style="font-size:18px;">search</span>
                <span class="hidden sm:inline">Cari</span>
            </button>
        </form>
    </div>
</div>

{{-- ── FILTER CHIPS ── --}}
@php
    $activeFilter = request('jenis', 'semua');
    $chips = [
        ['key' => 'semua',    'label' => 'Semua',    'icon' => 'grid_view'],
        ['key' => 'futsal',   'label' => 'Futsal',   'icon' => 'sports_soccer'],
        ['key' => 'badminton','label' => 'Badminton','icon' => 'sports_tennis'],
        ['key' => 'basket',   'label' => 'Basket',   'icon' => 'sports_basketball'],
        ['key' => 'tennis',   'label' => 'Tennis',   'icon' => 'sports_tennis'],
        ['key' => 'voli',     'label' => 'Voli',     'icon' => 'sports_volleyball'],
    ];
@endphp

<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    <div class="flex items-center gap-2 overflow-x-auto pb-1 flex-1" style="scrollbar-width:none;-webkit-overflow-scrolling:touch;">
        @foreach($chips as $chip)
            <a href="{{ request()->fullUrlWithQuery(['jenis' => $chip['key'], 'page' => 1]) }}"
               class="filter-chip {{ $activeFilter === $chip['key'] ? 'active' : '' }}">
                <span class="chip-icon material-symbols-outlined"
                      style="font-variation-settings:'FILL' {{ $activeFilter === $chip['key'] ? '1' : '0' }};">{{ $chip['icon'] }}</span>
                {{ $chip['label'] }}
            </a>
        @endforeach
    </div>
    <div class="shrink-0">
        @if(isset($courts))
            <span class="results-count">
                <span class="material-symbols-outlined" style="font-size:14px;">inventory_2</span>
                @if(method_exists($courts,'total'))
                    {{ $courts->total() }}
                @else
                    {{ $courts->count() }}
                @endif lapangan
            </span>
        @endif
    </div>
</div>

{{-- ── COURTS GRID ── --}}
@php
    /**
     * FIELD MAP (Blueprint → Actual Lapangan model)
     *   foto           → foto_lapangan
     *   jenis_lapangan → jenis_olahraga
     *   lokasi         → (future column; fallback below)
     *   nama_lapangan  ✓
     *   harga_per_jam  ✓
     *   status         ✓
     *
     * Dummy data is injected ONLY when $courts is absent
     * so Mahdi can visually test the template immediately.
     */
    if (!isset($courts)) {
        $courts = collect([
            (object)['id'=>1,'nama_lapangan'=>'Futsal GOR Merdeka',         'jenis_olahraga'=>'Futsal',   'harga_per_jam'=>80000, 'status'=>'tersedia',      'foto_lapangan'=>null],
            (object)['id'=>2,'nama_lapangan'=>'Badminton Sentosa',           'jenis_olahraga'=>'Badminton','harga_per_jam'=>50000, 'status'=>'tersedia',      'foto_lapangan'=>null],
            (object)['id'=>3,'nama_lapangan'=>'Basket Hall Diponegoro',      'jenis_olahraga'=>'Basket',  'harga_per_jam'=>120000,'status'=>'pemeliharaan',  'foto_lapangan'=>null],
            (object)['id'=>4,'nama_lapangan'=>'Tennis Court Bukit Mas',      'jenis_olahraga'=>'Tennis',  'harga_per_jam'=>95000, 'status'=>'tersedia',      'foto_lapangan'=>null],
            (object)['id'=>5,'nama_lapangan'=>'Voli Pantai Ancol',           'jenis_olahraga'=>'Voli',    'harga_per_jam'=>60000, 'status'=>'tersedia',      'foto_lapangan'=>null],
            (object)['id'=>6,'nama_lapangan'=>'Futsal Arena Kencana Premier','jenis_olahraga'=>'Futsal',  'harga_per_jam'=>75000, 'status'=>'tersedia',      'foto_lapangan'=>null],
        ]);
    }

    $sportMeta = [
        'futsal'    => ['icon'=>'sports_soccer',     'chip'=>'futsal',    'bg'=>'#dfe8ff','fg'=>'#00458e'],
        'badminton' => ['icon'=>'sports_tennis',      'chip'=>'badminton', 'bg'=>'#d3e3ff','fg'=>'#004882'],
        'basket'    => ['icon'=>'sports_basketball',  'chip'=>'basket',    'bg'=>'#fde8d3','fg'=>'#7a3000'],
        'tennis'    => ['icon'=>'sports_tennis',      'chip'=>'tennis',    'bg'=>'#d2f4e4','fg'=>'#005230'],
        'voli'      => ['icon'=>'sports_volleyball',  'chip'=>'voli',      'bg'=>'#ecdeff','fg'=>'#4b0082'],
    ];

    $dummyRatings = [4.9, 4.7, 4.2, 4.8, 4.6, 4.5, 4.3, 4.7];
    $rIdx = 0;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

    @forelse($courts as $court)
        @php
            $sportRaw   = $court->jenis_olahraga ?? $court->jenis_lapangan ?? 'Olahraga';
            $sportKey   = strtolower(trim($sportRaw));
            $meta       = $sportMeta[$sportKey] ?? ['icon'=>'sports','chip'=>'default','bg'=>'#eeeef0','fg'=>'#414753'];

            $imgSrc     = null;
            if (!empty($court->foto_lapangan))  $imgSrc = asset('storage/' . $court->foto_lapangan);
            elseif (!empty($court->foto))        $imgSrc = asset('storage/' . $court->foto);

            $status      = $court->status ?? 'tersedia';
            $statusKey   = match(strtolower(trim($status))) {
                'tersedia'     => 'tersedia',
                'pemeliharaan' => 'pemeliharaan',
                default        => 'tidak',
            };
            $statusLabel = ucwords(str_replace('_', ' ', $status));
            $isAvailable = $statusKey === 'tersedia';

            $lokasi  = $court->lokasi
                    ?? ($court->owner->nama_bisnis ?? null)
                    ?? 'Jakarta, Indonesia';

            $rating     = $court->rating ?? ($dummyRatings[$rIdx % count($dummyRatings)]);
            $fullStars  = (int) floor($rating);
            $halfStar   = ($rating - $fullStars) >= 0.5;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            $rIdx++;
        @endphp

        <div class="court-card" id="court-card-{{ $court->id }}">

            {{-- Image --}}
            <div class="court-card-img-wrap">
                @if($imgSrc)
                    <img src="{{ $imgSrc }}" alt="{{ $court->nama_lapangan }}" loading="lazy"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="img-placeholder" style="display:none;">
                        <span class="material-symbols-outlined ph-icon" style="font-variation-settings:'FILL' 0;">image_not_supported</span>
                        <p>Foto tidak tersedia</p>
                    </div>
                @else
                    <div class="img-placeholder">
                        <span class="material-symbols-outlined ph-icon" style="font-variation-settings:'FILL' 0;">{{ $meta['icon'] }}</span>
                        <p>{{ $court->nama_lapangan }}</p>
                    </div>
                @endif

                <span class="category-chip-img {{ $meta['chip'] }}">
                    <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;font-size:13px;">{{ $meta['icon'] }}</span>
                    {{ $sportRaw }}
                </span>

                <span class="status-badge {{ $statusKey }}">{{ $statusLabel }}</span>
            </div>

            {{-- Body --}}
            <div class="court-card-body">
                <h2 class="court-name">{{ $court->nama_lapangan }}</h2>

                <p class="court-location">
                    <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 0;">location_on</span>
                    {{ $lokasi }}
                </p>

                <span class="court-sport-label" style="background:{{ $meta['bg'] }};color:{{ $meta['fg'] }};">
                    <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;font-size:13px;">{{ $meta['icon'] }}</span>
                    {{ $sportRaw }}
                </span>

                <div class="star-rating">
                    <span class="stars">
                        @for($s = 0; $s < $fullStars; $s++)&#9733;@endfor
                        @if($halfStar)&#9733;@endif
                        @for($s = 0; $s < $emptyStars; $s++)&#9734;@endfor
                    </span>
                    <span class="rating-text">{{ number_format($rating, 1) }} / 5.0</span>
                </div>

                <div class="court-price-row">
                    <div>
                        <div class="court-price-label">Mulai dari</div>
                        <div>
                            <span class="court-price-value">Rp {{ number_format($court->harga_per_jam, 0, ',', '.') }}</span>
                            <span class="court-price-unit"> / jam</span>
                        </div>
                    </div>
                </div>

                @if($isAvailable)
                    <a href="{{ route('booking.create', $court->id) }}"
                       class="btn-pesan" id="btn-pesan-{{ $court->id }}">
                        <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">event_available</span>
                        Pesan Sekarang
                    </a>
                @else
                    <span class="btn-pesan disabled">
                        <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 0;">block</span>
                        Tidak Tersedia
                    </span>
                @endif
            </div>
        </div>

    @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3">
            <div class="empty-state">
                <span class="empty-icon material-symbols-outlined" style="font-variation-settings:'FILL' 0;">search_off</span>
                <h3>Lapangan Tidak Ditemukan</h3>
                <p>
                    @if(request('search') || (request('jenis') && request('jenis') !== 'semua'))
                        Tidak ada hasil untuk
                        @if(request('search'))"<strong>{{ request('search') }}</strong>"@endif
                        @if(request('jenis') && request('jenis') !== 'semua')
                            kategori <strong>{{ ucfirst(request('jenis')) }}</strong>
                        @endif.
                    @else
                        Belum ada lapangan yang terdaftar saat ini.
                    @endif
                </p>
                @if(request('search') || request('jenis'))
                    <a href="{{ url()->current() }}" class="btn-pesan"
                       style="display:inline-flex;width:auto;padding:10px 28px;margin:16px auto 0;">
                        <span class="material-symbols-outlined" style="font-size:17px;">restart_alt</span>
                        Reset Filter
                    </a>
                @endif
            </div>
        </div>
    @endforelse

</div>

{{-- ── PAGINATION ── --}}
@if(isset($courts) && method_exists($courts,'hasPages') && $courts->hasPages())
    <div class="pagination-outer">
        {{ $courts->appends(request()->query())->links() }}
    </div>
@endif

{{-- ── PAGE SCRIPTS ── --}}
<script>
(function () {
    'use strict';

    /* Debounced live search */
    var inp = document.getElementById('hero-search-input');
    if (inp) {
        var t;
        inp.addEventListener('input', function () {
            clearTimeout(t);
            t = setTimeout(function () { inp.closest('form').submit(); }, 500);
        });
    }

    /* Subtle 3-D tilt on card hover */
    document.querySelectorAll('.court-card').forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
            var r  = card.getBoundingClientRect();
            var dx = (e.clientX - (r.left + r.width / 2))  / (r.width / 2);
            var dy = (e.clientY - (r.top  + r.height / 2)) / (r.height / 2);
            card.style.transform  = 'translateY(-4px) rotateX(' + (-dy * 4).toFixed(2) + 'deg) rotateY(' + (dx * 4).toFixed(2) + 'deg)';
            card.style.transition = 'transform .05s ease';
        });
        card.addEventListener('mouseleave', function () {
            card.style.transform  = '';
            card.style.transition = 'transform .25s ease, box-shadow .25s ease';
        });
    });
}());
</script>

@endsection
