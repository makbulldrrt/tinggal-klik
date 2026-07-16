@extends('layouts.admin')

@section('title', 'Daftar Owner')
@section('page_title', 'Daftar Owner / Mitra')

@section('content')
<div class="space-y-6">
    <form method="GET" action="{{ route('admin.owners.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[240px]">
            <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pencarian</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama pemilik atau nama bisnis/vendor..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring focus:ring-sky-200 transition-all text-sm outline-none">
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.owners.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">Reset</a>
            <button type="submit" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-semibold hover:bg-sky-700 transition-colors shadow-sm shadow-sky-100">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-900">Manajemen Owner Lapangan</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/70">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Nama Pemilik</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Nama Bisnis / Vendor</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Jumlah Lapangan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Email</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($owners as $owner)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $owner->name }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-700 font-semibold">{{ $owner->nama_bisnis ?? '—' }}</td>
                        <td class="px-4 py-4 text-center whitespace-nowrap text-emerald-600 font-bold">{{ $owner->lapangan_count }} Lapangan</td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-500">{{ $owner->email }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-xs">Belum ada owner yang terdaftar atau sesuai pencarian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($owners->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $owners->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
