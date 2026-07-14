@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pesan Jadwal Lapangan</h1>
        <p class="text-gray-600 mt-1">{{ $lapangan->nama_lapangan }}</p>
        <p class="text-lg font-semibold text-blue-700 mt-1">
            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} / jam
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 rounded-lg px-4 py-3 mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-800 rounded-lg px-4 py-3 mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('booking.store') }}" class="space-y-6" id="form-pemesanan">
            @csrf

            <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">
            <input type="hidden" name="jam_mulai" id="input-jam-mulai">
            <input type="hidden" name="jam_selesai" id="input-jam-selesai">

            <div>
                <label for="tanggal_pesan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Tanggal Pesan
                </label>
                <input
                    id="tanggal_pesan"
                    type="date"
                    name="tanggal_pesan"
                    value="{{ old('tanggal_pesan') }}"
                    required
                    min="{{ date('Y-m-d') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_pesan') border-red-500 @enderror"
                >
                @error('tanggal_pesan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <p class="block text-sm font-semibold text-gray-700 mb-3">Pilih Jam Sewa</p>
                <div class="flex gap-3 flex-wrap text-xs mb-3">
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-sm bg-emerald-500"></span> Tersedia
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-sm bg-red-500"></span> Terbooking
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-sm bg-blue-500"></span> Dipilih
                    </span>
                </div>
                <div id="slot-loading" class="hidden text-sm text-gray-400 italic mb-2">Memuat ketersediaan...</div>
                <div id="slot-hint" class="text-xs text-gray-500 mb-3">Pilih tanggal terlebih dahulu untuk melihat ketersediaan jam.</div>
                <div id="grid-jam" class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                    @for ($h = 7; $h <= 22; $h++)
                        @php $label = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                        <button
                            type="button"
                            data-jam="{{ $label }}"
                            data-state="available"
                            class="slot-btn px-2 py-2.5 rounded-lg text-xs font-semibold bg-emerald-500 text-white transition-all duration-150 opacity-40 cursor-not-allowed"
                            disabled
                        >{{ $label }}</button>
                    @endfor
                </div>
                @error('jam_mulai')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
                @error('jam_selesai')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div id="selection-info" class="hidden rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 space-y-1">
                <p class="text-sm text-blue-800">
                    <span class="font-semibold">Mulai:</span>
                    <span id="disp-mulai">—</span>
                    &nbsp;→&nbsp;
                    <span class="font-semibold">Selesai:</span>
                    <span id="disp-selesai">—</span>
                </p>
                <p class="text-sm font-bold text-blue-900">
                    Total Bayar: <span id="disp-total">Rp 0</span>
                </p>
                <button type="button" id="btn-reset" class="text-xs text-red-500 underline mt-1">Reset Pilihan</button>
            </div>

            <div class="pt-1">
                <button
                    type="submit"
                    id="btn-submit"
                    disabled
                    class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold rounded-full px-6 py-3 text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-40 disabled:cursor-not-allowed"
                >
                    Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    var lapanganId   = {{ $lapangan->id }};
    var hargaPerJam  = {{ $lapangan->harga_per_jam }};
    var bookedHours  = new Set();
    var selectedJam  = [];

    var inputMulai   = document.getElementById('input-jam-mulai');
    var inputSelesai = document.getElementById('input-jam-selesai');
    var tanggalEl    = document.getElementById('tanggal_pesan');
    var gridEl       = document.getElementById('grid-jam');
    var loadingEl    = document.getElementById('slot-loading');
    var hintEl       = document.getElementById('slot-hint');
    var infoEl       = document.getElementById('selection-info');
    var dispMulai    = document.getElementById('disp-mulai');
    var dispSelesai  = document.getElementById('disp-selesai');
    var dispTotal    = document.getElementById('disp-total');
    var btnSubmit    = document.getElementById('btn-submit');
    var btnReset     = document.getElementById('btn-reset');

    function allButtons() {
        return Array.from(gridEl.querySelectorAll('.slot-btn'));
    }

    function jamToHour(jamStr) {
        return parseInt(jamStr.split(':')[0], 10);
    }

    function applySlotStates() {
        allButtons().forEach(function (btn) {
            var jam = btn.getAttribute('data-jam');
            var hour = jamToHour(jam);
            if (bookedHours.has(hour)) {
                btn.className = 'slot-btn px-2 py-2.5 rounded-lg text-xs font-semibold bg-red-500 text-white transition-all duration-150 cursor-not-allowed';
                btn.setAttribute('data-state', 'booked');
                btn.disabled = true;
                btn.textContent = 'Terbooking';
            } else if (selectedJam.indexOf(jam) !== -1) {
                btn.className = 'slot-btn px-2 py-2.5 rounded-lg text-xs font-semibold bg-blue-500 text-white transition-all duration-150 cursor-pointer ring-2 ring-blue-300';
                btn.setAttribute('data-state', 'selected');
                btn.disabled = false;
                btn.textContent = jam;
            } else {
                btn.className = 'slot-btn px-2 py-2.5 rounded-lg text-xs font-semibold bg-emerald-500 text-white transition-all duration-150 cursor-pointer hover:bg-emerald-600';
                btn.setAttribute('data-state', 'available');
                btn.disabled = false;
                btn.textContent = jam;
            }
        });
    }

    function updateSummary() {
        if (selectedJam.length === 0) {
            infoEl.classList.add('hidden');
            btnSubmit.disabled = true;
            inputMulai.value = '';
            inputSelesai.value = '';
            return;
        }

        var sorted   = selectedJam.slice().sort();
        var mulai    = sorted[0];
        var endHour  = parseInt(sorted[sorted.length - 1].split(':')[0], 10) + 1;
        var selesai  = String(endHour).padStart(2, '0') + ':00';
        var durasi   = sorted.length;
        var total    = durasi * hargaPerJam;

        inputMulai.value        = mulai;
        inputSelesai.value      = selesai;
        dispMulai.textContent   = mulai;
        dispSelesai.textContent = selesai;
        dispTotal.textContent   = 'Rp ' + total.toLocaleString('id-ID');
        infoEl.classList.remove('hidden');
        btnSubmit.disabled = false;
    }

    function hasBookedSlotBetween(h1, h2) {
        var lo = Math.min(h1, h2);
        var hi = Math.max(h1, h2);
        for (var h = lo; h < hi; h++) {
            if (bookedHours.has(h)) return true;
        }
        return false;
    }

    allButtons().forEach(function (btn) {
        btn.addEventListener('click', function () {
            var jam = btn.getAttribute('data-jam');
            var idx = selectedJam.indexOf(jam);

            if (idx !== -1) {
                selectedJam.splice(idx, 1);
            } else {
                if (selectedJam.length === 0) {
                    selectedJam.push(jam);
                } else {
                    var sorted = selectedJam.slice().sort();
                    var first  = parseInt(sorted[0].split(':')[0], 10);
                    var last   = parseInt(sorted[sorted.length - 1].split(':')[0], 10);
                    var h      = parseInt(jam.split(':')[0], 10);
                    if (h < first) {
                        if (!hasBookedSlotBetween(h, first)) {
                            for (var i = h; i < first; i++) {
                                selectedJam.push(String(i).padStart(2, '0') + ':00');
                            }
                        }
                    } else if (h > last) {
                        if (!hasBookedSlotBetween(last + 1, h + 1)) {
                            for (var i = last + 1; i <= h; i++) {
                                selectedJam.push(String(i).padStart(2, '0') + ':00');
                            }
                        }
                    } else {
                        selectedJam = [jam];
                    }
                }
            }

            applySlotStates();
            updateSummary();
        });
    });

    btnReset.addEventListener('click', function () {
        selectedJam = [];
        applySlotStates();
        updateSummary();
    });

    tanggalEl.addEventListener('change', function () {
        var tanggal = tanggalEl.value;
        if (!tanggal) return;

        selectedJam = [];
        bookedHours = new Set();
        loadingEl.classList.remove('hidden');
        hintEl.classList.add('hidden');
        allButtons().forEach(function (btn) {
            btn.disabled = true;
            btn.className = 'slot-btn px-2 py-2.5 rounded-lg text-xs font-semibold bg-emerald-500 text-white transition-all duration-150 opacity-40 cursor-not-allowed';
            btn.textContent = btn.getAttribute('data-jam');
        });
        updateSummary();

        fetch('/api/lapangan/' + lapanganId + '/availability?tanggal=' + tanggal, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            bookedHours = new Set();
            data.forEach(function (row) {
                var startH = parseInt(row.jam_mulai.split(':')[0], 10);
                var endH   = parseInt(row.jam_selesai.split(':')[0], 10);
                for (var h = startH; h < endH; h++) {
                    bookedHours.add(h);
                }
            });
            loadingEl.classList.add('hidden');
            applySlotStates();
        })
        .catch(function (err) {
            console.error(err);
            loadingEl.classList.add('hidden');
            hintEl.classList.remove('hidden');
            hintEl.textContent = 'Gagal memuat ketersediaan. Coba pilih tanggal lagi.';
        });
    });
})();
</script>
@endsection

