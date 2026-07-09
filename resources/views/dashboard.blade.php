<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($lapangan as $item)
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-shadow duration-300">
                        <img src="{{ asset('storage/' . $item->foto_lapangan) }}" class="w-full h-48 object-cover rounded-xl" alt="{{ $item->nama_lapangan }}">
                        <h3 class="text-lg font-bold text-gray-900 mt-4">{{ $item->nama_lapangan }}</h3>
                        <p class="text-sm text-gray-500 capitalize mt-1">{{ $item->jenis_olahraga }}</p>
                        <p class="text-base font-semibold text-[#0066cc] mt-2">Rp {{ number_format($item->harga_per_jam, 0, ',', '.') }} / Jam</p>
                        <div class="mt-auto pt-4">
                            <button class="w-full bg-[#0066cc] hover:bg-[#0055aa] text-white font-medium py-2.5 px-4 rounded-full transition-colors duration-200">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
