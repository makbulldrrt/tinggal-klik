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
        <form method="POST" action="{{ route('booking.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

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
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           @error('tanggal_pesan') border-red-500 @enderror"
                >
                @error('tanggal_pesan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="jam_mulai" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Jam Mulai
                    </label>
                    <input
                        id="jam_mulai"
                        type="time"
                        name="jam_mulai"
                        value="{{ old('jam_mulai') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               @error('jam_mulai') border-red-500 @enderror"
                    >
                    @error('jam_mulai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_selesai" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Jam Selesai
                    </label>
                    <input
                        id="jam_selesai"
                        type="time"
                        name="jam_selesai"
                        value="{{ old('jam_selesai') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               @error('jam_selesai') border-red-500 @enderror"
                    >
                    @error('jam_selesai')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold
                           rounded-full px-6 py-3 text-sm transition-all duration-200
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
