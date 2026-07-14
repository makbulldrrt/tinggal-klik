@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-8 text-white text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 mb-4 shadow-inner">
                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">handshake</span>
            </div>
            <h1 class="text-2xl font-bold mb-2">Pendaftaran Mitra Tinggal-Klik</h1>
            <p class="text-indigo-100 text-sm max-w-lg mx-auto">Bergabunglah bersama kami dan mulailah mengelola pemesanan lapangan olahraga Anda dengan sistem yang modern dan mudah digunakan.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('mitra.submit') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="nama_pemilik" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Pemilik</label>
                        <input type="text" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', auth()->user()->name) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" placeholder="Masukkan nama lengkap Anda sesuai KTP" required>
                        @error('nama_pemilik')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_bisnis" class="block text-sm font-semibold text-slate-700 mb-2">Nama Bisnis / Vendor Lapangan</label>
                        <input type="text" id="nama_bisnis" name="nama_bisnis" value="{{ old('nama_bisnis') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" placeholder="Contoh: Arena Futsal Kencana" required>
                        @error('nama_bisnis')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_telepon" class="block text-sm font-semibold text-slate-700 mb-2">Nomor WhatsApp / Telepon Aktif</label>
                        <input type="tel" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" placeholder="Contoh: 081234567890" required>
                        @error('nomor_telepon')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alamat_operasional" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap Operasional Lapangan</label>
                        <textarea id="alamat_operasional" name="alamat_operasional" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800 resize-none" placeholder="Tuliskan alamat lengkap beserta patokan jalan..." required>{{ old('alamat_operasional') }}</textarea>
                        @error('alamat_operasional')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-between border-t border-slate-100">
                        <a href="{{ url()->previous() }}" class="text-sm text-slate-500 hover:text-slate-800 font-medium transition-colors">Batal & Kembali</a>
                        <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
                            Kirim Pendaftaran
                            <span class="material-symbols-outlined text-[18px]">send</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
