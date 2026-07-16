@extends('layouts.admin')

@section('title', 'Penarikan Dana')
@section('page_title', 'Penarikan Dana')

@section('content')
<div class="space-y-6">
    <form method="GET" action="{{ route('admin.withdrawals.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[240px]">
            <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pencarian Owner</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama owner..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring focus:ring-sky-200 transition-all text-sm outline-none">
        </div>
        <div class="w-48">
            <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
            <select id="status" name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring focus:ring-sky-200 transition-all text-sm outline-none">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.withdrawals.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">Reset</a>
            <button type="submit" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl text-sm font-semibold hover:bg-sky-700 transition-colors shadow-sm shadow-sky-100">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-900">Daftar Pengajuan Penarikan Dana</h2>
        </div>
        
        @if(session('success'))
        <div class="m-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/70">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Pemilik (Owner)</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Bank Tujuan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">No. Rekening</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Jumlah Penarikan</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($withdrawals as $w)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-800">{{ $w->user->name ?? '—' }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-600">{{ $w->bank_tujuan }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-slate-600">{{ $w->nomor_rekening }}</td>
                        <td class="px-4 py-4 text-right whitespace-nowrap font-bold text-slate-900">Rp {{ number_format($w->jumlah_penarikan, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-center whitespace-nowrap">
                            @php
                                $bc = match($w->status) {
                                    'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                    default    => 'bg-amber-50 text-amber-700 border-amber-200',
                                };
                                $lbl = match($w->status) {
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    default    => 'Pending',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $bc }}">
                                {{ $lbl }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center whitespace-nowrap">
                            @if($w->status === 'pending')
                            <div class="flex items-center justify-center gap-2">
                                <form method="POST" action="{{ route('admin.withdrawals.approve', $w->id) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('admin.withdrawals.reject', $w->id) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition">Tolak</button>
                                </form>
                            </div>
                            @else
                            <span class="text-slate-400 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">Belum ada pengajuan penarikan dana atau sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($withdrawals->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $withdrawals->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
