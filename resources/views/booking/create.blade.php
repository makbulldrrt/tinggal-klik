@extends('layouts.app')

@section('title', 'Pesan Lapangan - ' . $lapangan->nama_lapangan)

@section('content')
<div class="max-w-5xl mx-auto py-8">

    {{-- ── PAGE HEADER ──────────────────────────────────────────────────────── --}}
    <div class="mb-8">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-1.5 text-sm text-on-surface-variant hover:text-primary transition-colors mb-4">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Katalog
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface tracking-tight">Pesan Lapangan</h1>
        <p class="text-on-surface-variant mt-1 text-sm">Lengkapi detail di bawah ini untuk mengamankan slot waktu Anda.</p>
    </div>

    {{-- ── SUCCESS / ERROR FLASH MESSAGE ───────────────────────────────────── --}}
    @if (session('success'))
        <div class="flex items-start gap-3 bg-tertiary-fixed/30 border border-tertiary text-on-tertiary-fixed rounded-xl p-4 mb-6 text-sm">
            <span class="material-symbols-outlined text-tertiary shrink-0" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-start gap-3 bg-error-container border border-error text-on-error-container rounded-xl p-4 mb-6 text-sm">
            <span class="material-symbols-outlined text-error shrink-0" style="font-variation-settings: 'FILL' 1;">error</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ── MAIN GRID: 2 COLUMNS (INFO + FORM) ──────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

        {{-- ════════════════════════════════════════════════════════════════════
             KOLOM KIRI — Informasi Detail Lapangan (2/5 width)
        ════════════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Card Gambar --}}
            <div class="bg-surface-container-lowest card-shadow rounded-2xl overflow-hidden">
                @if (!empty($lapangan->gambar))
                    <img
                        src="{{ asset('storage/' . $lapangan->gambar) }}"
                        alt="Foto {{ $lapangan->nama_lapangan }}"
                        class="w-full h-52 object-cover"
                    >
                @else
                    {{-- Fallback Placeholder Gambar --}}
                    <div class="w-full h-52 bg-surface-container flex flex-col items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[56px] text-outline" style="font-variation-settings: 'FILL' 0;">sports_tennis</span>
                        <span class="text-xs text-on-surface-variant">Foto belum tersedia</span>
                    </div>
                @endif
            </div>

            {{-- Card Detail Info --}}
            <div class="bg-surface-container-lowest text-on-surface card-shadow rounded-2xl p-6 space-y-4">

                {{-- Nama & Badge Jenis --}}
                <div>
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h2 class="text-lg font-bold text-on-surface leading-tight">
                            {{ $lapangan->nama_lapangan }}
                        </h2>
                        {{-- M3 Assist Chip / Badge --}}
                        <span class="shrink-0 inline-flex items-center gap-1 bg-primary-fixed text-on-primary-fixed text-xs font-semibold px-3 py-1 rounded-full capitalize">
                            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">sports</span>
                            {{ $lapangan->jenis_olahraga ?? 'Umum' }}
                        </span>
                    </div>

                    {{-- Deskripsi --}}
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        {{ $lapangan->deskripsi ?? 'Tidak ada deskripsi untuk lapangan ini.' }}
                    </p>
                </div>

                {{-- Divider --}}
                <hr class="border-hairline">

                {{-- Harga per Jam --}}
                <div class="flex items-center justify-between">
                    <span class="text-sm text-on-surface-variant font-medium">Harga per Jam</span>
                    <div class="text-right">
                        <span class="text-xl font-bold text-primary">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-on-surface-variant"> / jam</span>
                    </div>
                </div>

                {{-- Info Tambahan --}}
                <div class="space-y-2 pt-1">
                    @if (!empty($lapangan->gmaps_link))
                        <a href="{{ $lapangan->gmaps_link }}"
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 text-sm text-primary hover:underline">
                            <span class="material-symbols-outlined text-[16px]">location_on</span>
                            Lihat Lokasi di Peta
                        </a>
                    @endif
                    <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                        Pembayaran dilakukan setelah booking dikonfirmasi
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════════
             KOLOM KANAN — Form Pemesanan (3/5 width)
        ════════════════════════════════════════════════════════════════════ --}}
        <div class="lg:col-span-3">
            <div class="bg-surface-container-lowest text-on-surface card-shadow rounded-2xl p-6 md:p-8">

                <div class="mb-6">
                    <h3 class="text-lg font-bold text-on-surface">Detail Pemesanan</h3>
                    <p class="text-sm text-on-surface-variant mt-0.5">Pilih tanggal dan slot waktu yang Anda inginkan.</p>
                </div>

                {{-- ── FORM ─────────────────────────────────────────────────── --}}
                <form
                    id="booking-form"
                    action="{{ route('booking.store') }}"
                    method="POST"
                    class="space-y-5"
                    novalidate
                >
                    @csrf

                    {{-- Hidden: lapangan_id --}}
                    <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

                    {{-- ── INPUT: TANGGAL ────────────────────────────────────── --}}
                    <div>
                        <label for="tanggal" class="block text-sm font-semibold text-on-surface mb-1.5">
                            Tanggal Bermain
                            <span class="text-error">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">calendar_today</span>
                            <input
                                id="tanggal"
                                type="date"
                                name="tanggal"
                                value="{{ old('tanggal') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full bg-transparent border rounded-xl py-3 pl-11 pr-4 text-sm text-on-surface
                                       focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition
                                       @error('tanggal') border-error focus:ring-error @else border-outline @enderror"
                            >
                        </div>
                        @error('tanggal')
                            <p class="text-error text-sm mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- ── INPUT: JAM MULAI & JAM SELESAI (Inline Grid) ─────── --}}
                    <div class="grid grid-cols-2 gap-4">

                        {{-- Jam Mulai --}}
                        <div>
                            <label for="jam_mulai" class="block text-sm font-semibold text-on-surface mb-1.5">
                                Jam Mulai
                                <span class="text-error">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">schedule</span>
                                <input
                                    id="jam_mulai"
                                    type="time"
                                    name="jam_mulai"
                                    value="{{ old('jam_mulai') }}"
                                    step="1800"
                                    class="w-full bg-transparent border rounded-xl py-3 pl-11 pr-4 text-sm text-on-surface
                                           focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition
                                           @error('jam_mulai') border-error focus:ring-error @else border-outline @enderror"
                                >
                            </div>
                            @error('jam_mulai')
                                <p class="text-error text-sm mt-1.5 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Jam Selesai --}}
                        <div>
                            <label for="jam_selesai" class="block text-sm font-semibold text-on-surface mb-1.5">
                                Jam Selesai
                                <span class="text-error">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">schedule</span>
                                <input
                                    id="jam_selesai"
                                    type="time"
                                    name="jam_selesai"
                                    value="{{ old('jam_selesai') }}"
                                    step="1800"
                                    class="w-full bg-transparent border rounded-xl py-3 pl-11 pr-4 text-sm text-on-surface
                                           focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition
                                           @error('jam_selesai') border-error focus:ring-error @else border-outline @enderror"
                                >
                            </div>
                            @error('jam_selesai')
                                <p class="text-error text-sm mt-1.5 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- ── RINGKASAN HARGA (Real-time via JS) ───────────────── --}}
                    <div id="price-summary" class="hidden bg-surface-container-low rounded-xl p-4 space-y-2 border border-hairline">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant">Durasi</span>
                            <span id="summary-duration" class="font-semibold text-on-surface">—</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant">Harga per Jam</span>
                            <span class="font-semibold text-on-surface">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</span>
                        </div>
                        <hr class="border-hairline">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-on-surface">Estimasi Total</span>
                            <span id="summary-total" class="text-lg font-bold text-primary">Rp 0</span>
                        </div>
                    </div>

                    {{-- ── DIVIDER ───────────────────────────────────────────── --}}
                    <hr class="border-hairline">

                    {{-- ── TOMBOL SUBMIT (M3 Filled Button — Pill Shape) ───────── --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button
                            id="submit-btn"
                            type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2
                                   bg-primary text-on-primary hover:bg-primary-hover
                                   rounded-full px-6 py-3 font-semibold text-sm
                                   transition-all duration-200 active:scale-95 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                            style="--tw-bg-opacity: 1; background-color: #004e9f;"
                            onmouseover="this.style.backgroundColor='#00458e'"
                            onmouseout="this.style.backgroundColor='#004e9f'"
                        >
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">event_available</span>
                            Konfirmasi & Pesan Sekarang
                        </button>

                        <a href="{{ url()->previous() }}"
                           class="inline-flex items-center justify-center gap-2
                                  border border-outline text-on-surface-variant hover:bg-surface-container-low
                                  rounded-full px-6 py-3 font-semibold text-sm
                                  transition-all duration-200 focus:outline-none">
                            Batal
                        </a>
                    </div>

                    {{-- Info Kebijakan --}}
                    <p class="text-xs text-on-surface-variant text-center leading-relaxed">
                        Dengan memesan, Anda menyetujui
                        <a href="#" class="text-primary hover:underline">Syarat & Ketentuan</a>
                        layanan Tinggal-Klik.
                    </p>

                </form>
            </div>
        </div>
        {{-- ── END GRID ──────────────────────────────────────────────────────── --}}
    </div>
</div>

{{-- ── REAL-TIME PRICE CALCULATOR SCRIPT ────────────────────────────────────── --}}
<script>
    (() => {
        const hargaPerJam   = {{ (float) $lapangan->harga_per_jam }};
        const inputMulai    = document.getElementById('jam_mulai');
        const inputSelesai  = document.getElementById('jam_selesai');
        const priceSummary  = document.getElementById('price-summary');
        const summaryDur    = document.getElementById('summary-duration');
        const summaryTotal  = document.getElementById('summary-total');

        /**
         * Format angka ke format Rupiah.
         * @param {number} number
         * @returns {string}
         */
        function formatRupiah(number) {
            return 'Rp ' + Math.round(number).toLocaleString('id-ID');
        }

        /**
         * Hitung durasi dan estimasi harga secara real-time.
         */
        function calculate() {
            const mulai   = inputMulai.value;
            const selesai = inputSelesai.value;

            if (!mulai || !selesai || selesai <= mulai) {
                priceSummary.classList.add('hidden');
                return;
            }

            const [mulaiH, mulaiM]     = mulai.split(':').map(Number);
            const [selesaiH, selesaiM] = selesai.split(':').map(Number);

            const totalMenit = (selesaiH * 60 + selesaiM) - (mulaiH * 60 + mulaiM);

            if (totalMenit <= 0) {
                priceSummary.classList.add('hidden');
                return;
            }

            const durasiJam  = totalMenit / 60;
            const totalHarga = durasiJam * hargaPerJam;

            // Format durasi yang ramah baca
            const jam    = Math.floor(durasiJam);
            const menit  = totalMenit % 60;
            let durasiStr = '';
            if (jam > 0)   durasiStr += `${jam} jam `;
            if (menit > 0) durasiStr += `${menit} menit`;

            summaryDur.textContent   = durasiStr.trim();
            summaryTotal.textContent = formatRupiah(totalHarga);
            priceSummary.classList.remove('hidden');
        }

        inputMulai.addEventListener('change', calculate);
        inputSelesai.addEventListener('change', calculate);

        // Jalankan saat halaman load (jika ada nilai old() dari validasi sebelumnya)
        calculate();
    })();
</script>
@endsection
