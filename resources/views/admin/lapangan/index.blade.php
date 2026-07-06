<x-app-layout>
    <x-slot name="header">
        <h2 style="font-family:system-ui,Inter,sans-serif;font-size:17px;font-weight:600;color:#1d1d1f;margin:0;">
            Manajemen Lapangan
        </h2>
    </x-slot>

    <style>
        .lp-wrap{max-width:1100px;margin:32px auto;padding:0 24px;font-family:system-ui,Inter,sans-serif;color:#1d1d1f}
        .lp-topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
        .lp-title{font-size:22px;font-weight:700;color:#1d1d1f;letter-spacing:-.3px}
        .btn-primary{display:inline-flex;align-items:center;gap:7px;background:#0066cc;color:#fff;font-size:15px;font-weight:500;padding:9px 22px;border-radius:999px;text-decoration:none;border:none;cursor:pointer;transition:background .15s}
        .btn-primary:hover{background:#0055aa}
        .btn-edit{display:inline-flex;align-items:center;background:transparent;color:#0066cc;font-size:14px;font-weight:500;padding:6px 14px;border-radius:999px;border:1px solid #0066cc;text-decoration:none;transition:background .15s,color .15s}
        .btn-edit:hover{background:#0066cc;color:#fff}
        .btn-delete{display:inline-flex;align-items:center;background:transparent;color:#c0392b;font-size:14px;font-weight:500;padding:6px 14px;border-radius:999px;border:1px solid #e74c3c;text-decoration:none;cursor:pointer;transition:background .15s,color .15s}
        .btn-delete:hover{background:#e74c3c;color:#fff}
        .alert-success{background:#f0faf4;border:1px solid #b7dfc8;color:#1d7a3f;font-size:15px;padding:13px 18px;border-radius:12px;margin-bottom:20px}
        .card{background:#fff;border:1px solid #e0e0e0;border-radius:14px;overflow:hidden}
        table{width:100%;border-collapse:collapse;font-size:15px}
        thead tr{background:#f5f5f7;border-bottom:1px solid #e0e0e0}
        th{padding:13px 16px;text-align:left;font-size:13px;font-weight:600;color:#6e6e73;letter-spacing:.3px;text-transform:uppercase}
        td{padding:14px 16px;border-bottom:1px solid #e0e0e0;color:#1d1d1f;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tbody tr:hover{background:#fafafa}
        .badge{display:inline-block;padding:3px 12px;border-radius:999px;font-size:12px;font-weight:600;letter-spacing:.2px}
        .badge-tersedia{background:#e8f9ef;color:#1a7f45}
        .badge-pemeliharaan{background:#fff3e0;color:#c25f00}
        .foto-thumb{width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #e0e0e0}
        .foto-empty{width:48px;height:48px;border-radius:8px;background:#f5f5f7;border:1px solid #e0e0e0;display:flex;align-items:center;justify-content:center}
        .actions{display:flex;gap:8px;align-items:center}
        .empty-row td{text-align:center;padding:48px;color:#6e6e73;font-size:15px}
        .pagination-wrap{padding:16px 20px;border-top:1px solid #e0e0e0}
    </style>

    <div class="lp-wrap">
        <div class="lp-topbar">
            <span class="lp-title">Daftar Lapangan</span>
            <a href="{{ route('admin.lapangan.create') }}" class="btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Lapangan Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama Lapangan</th>
                        <th>Jenis Olahraga</th>
                        <th>Harga / Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lapangan as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($lapangan->currentPage() - 1) * $lapangan->perPage() }}</td>
                        <td>
                            @if($item->foto_lapangan)
                                <img src="{{ asset('storage/' . $item->foto_lapangan) }}" alt="{{ $item->nama_lapangan }}" class="foto-thumb">
                            @else
                                <div class="foto-empty">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b0b0b8" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $item->nama_lapangan }}</strong></td>
                        <td>{{ $item->jenis_olahraga ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga_per_jam, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'tersedia' ? 'badge-tersedia' : 'badge-pemeliharaan' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.lapangan.edit', $item->id) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('admin.lapangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="7">Belum ada data lapangan. Silakan tambah lapangan baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($lapangan->hasPages())
            <div class="pagination-wrap">
                {{ $lapangan->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
