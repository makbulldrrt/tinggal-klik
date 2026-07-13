@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Profil Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi akun dan pengaturan keamanan Anda.</p>
        </div>
    </div>

    @if(session('status') === 'profile-updated')
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            Informasi profil berhasil diperbarui.
        </div>
    @endif
    
    @if(session('status') === 'password-updated')
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            Password berhasil diubah.
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="p-6 sm:p-8 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-800 mb-1">Informasi Dasar</h2>
            <p class="text-sm text-slate-500 mb-6">Perbarui foto profil, nama, dan alamat email akun Anda.</p>
            
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="flex flex-col sm:flex-row gap-8 items-start">
                    <div class="flex flex-col items-center gap-3 shrink-0">
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-slate-100 border-4 border-white shadow-md relative">
                            @if(auth()->user()->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-100 text-indigo-500">
                                    <span class="material-symbols-outlined text-5xl">person</span>
                                </div>
                            @endif
                        </div>
                        <div class="relative w-full">
                            <input type="file" name="foto" id="foto" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                            <label for="foto" class="flex justify-center w-full px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-lg hover:bg-indigo-100 transition-colors cursor-pointer text-center">
                                Ganti Foto
                            </label>
                        </div>
                        @error('foto')
                            <p class="text-xs text-red-500 mt-1 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex-1 space-y-5 w-full">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" required autofocus autocomplete="name">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" required autocomplete="username">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <h2 class="text-lg font-bold text-slate-800 mb-1">Ganti Password</h2>
            <p class="text-sm text-slate-500 mb-6">Pastikan akun Anda menggunakan password acak yang panjang agar tetap aman.</p>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                
                <div class="max-w-xl space-y-5">
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password Lama</label>
                        <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-colors text-sm text-slate-800" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                            Ganti Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
