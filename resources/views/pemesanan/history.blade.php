@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">
            @if($user->role === 'owner') Daftar Pesanan Masuk @else Riwayat Pemesanan Saya @endif
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            @if($user->role === 'owner') Semua pemesanan yang masuk ke lapangan milik Anda. @else Rekam jejak semua transaksi sewa lapangan Anda. @endif
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($pemesanans->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <span class="material-symbols-outlined text-slate-300 mb-4" style="font-size:56px;">receipt_long</span>
                <p class="text-slate-500 font-medium">Belum ada data pemesanan.</p>
                @if($user->role === 'pelanggan')
                    <a href="/lapangan" class="mt-4 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors">Jelajahi Lapangan</a>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Lapangan</th>
                            @if($user->role === 'owner')
                                <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pemesan</th>
                            @endif
                            <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Waktu</th>
                            <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                            <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($pemesanans as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-800">{{ $item->lapangan->nama_lapangan ?? '-' }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $item->lapangan->jenis_olahraga ?? '' }}</p>
                            </td>
                            @if($user->role === 'owner')
                                <td class="px-5 py-4">
                                    <p class="font-medium text-slate-700">{{ $item->user->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $item->user->email ?? '' }}</p>
                                </td>
                            @endif
                            <td class="px-5 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_pesan)->isoFormat('D MMM Y') }}
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                {{ substr($item->jam_mulai, 0, 5) }} – {{ substr($item->jam_selesai, 0, 5) }}
                            </td>
                            <td class="px-5 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4">
                                @if($item->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <span class="material-symbols-outlined text-[13px]">check_circle</span> Lunas
                                    </span>
                                @elseif($item->status_pembayaran === 'belum_bayar')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        <span class="material-symbols-outlined text-[13px]">schedule</span> Belum Bayar
                                    </span>
                                @elseif($item->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        <span class="material-symbols-outlined text-[13px]">cancel</span> Dibatalkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                        {{ $item->status_pembayaran }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($item->status_pembayaran === 'lunas')
                                    <a href="{{ route('booking.invoice', $item->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">receipt</span>
                                        Lihat Invoice
                                    </a>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @if($item->status_pembayaran === 'lunas')
                            @php
                                $ulasan = \Illuminate\Support\Facades\DB::table('ulasan')
                                    ->where('lapangan_id', $item->lapangan_id)
                                    ->where('user_id', $item->user_id)
                                    ->first();
                            @endphp
                            
                            @if($user->role === 'pelanggan' && !$ulasan)
                            <tr class="bg-indigo-50/30 border-b border-slate-100">
                                <td colspan="6" class="px-5 py-4">
                                    <form action="{{ route('ulasan.store') }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                        @csrf
                                        <input type="hidden" name="lapangan_id" value="{{ $item->lapangan_id }}">
                                        
                                        <div>
                                            <select name="rating" required class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                                <option value="">-- Rating Bintang --</option>
                                                <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                                <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                                <option value="3">⭐⭐⭐ (3/5)</option>
                                                <option value="2">⭐⭐ (2/5)</option>
                                                <option value="1">⭐ (1/5)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="flex-1 w-full">
                                            <textarea name="komentar" rows="1" placeholder="Tuliskan pengalaman Anda menggunakan lapangan ini..." class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 resize-none"></textarea>
                                        </div>
                                        
                                        <div>
                                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors whitespace-nowrap">Kirim Ulasan</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @elseif($user->role === 'pelanggan' && $ulasan)
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <td colspan="6" class="px-5 py-3">
                                    <div class="flex items-center gap-2 text-sm text-green-600 font-medium">
                                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                        ✓ Anda telah memberikan ulasan (Rating: {{ $ulasan->rating }}/5)
                                    </div>
                                </td>
                            </tr>
                            @elseif($user->role === 'owner' && $ulasan)
                            <tr class="bg-indigo-50/50 border-b border-slate-100">
                                <td colspan="7" class="px-5 py-4">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-indigo-400 mt-0.5" style="font-size:20px;">format_quote</span>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-sm font-semibold text-slate-700">Ulasan Pelanggan</span>
                                                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-bold">⭐ {{ $ulasan->rating }}/5</span>
                                            </div>
                                            <p class="text-sm text-slate-600 italic">"{{ $ulasan->komentar }}"</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
