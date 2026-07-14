<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pemesanan->id }} — Tinggal-Klik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f5f5f7; min-height: 100vh; display: flex; align-items: flex-start; justify-content: center; padding: 40px 20px; }
        .page { background: #fff; width: 100%; max-width: 680px; border-radius: 16px; box-shadow: 0 8px 40px rgba(0,0,0,.08); overflow: hidden; }
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 36px 40px; color: #fff; }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .logo { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }
        .logo span { opacity: .7; font-weight: 400; }
        .invoice-label { text-align: right; }
        .invoice-label p { font-size: 12px; opacity: .7; }
        .invoice-label h2 { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; margin-top: 2px; }
        .badge-lunas { display: inline-flex; align-items: center; gap: 6px; margin-top: 20px; background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3); padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 600; }
        .body { padding: 36px 40px; }
        .section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #94a3b8; margin-bottom: 12px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 28px; }
        .info-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; }
        .info-card label { font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; display: block; margin-bottom: 4px; }
        .info-card p { font-size: 14px; font-weight: 600; color: #1e293b; }
        .info-card small { font-size: 12px; color: #64748b; font-weight: 400; }
        .divider { border: none; border-top: 1px solid #e2e8f0; margin: 24px 0; }
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table th { text-align: left; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .06em; padding: 10px 0; border-bottom: 1px solid #e2e8f0; }
        .detail-table td { padding: 14px 0; font-size: 14px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .detail-table td:last-child { text-align: right; font-weight: 600; color: #1e293b; }
        .total-row { background: #f0f7ff; border-radius: 10px; margin-top: 8px; }
        .total-row td { padding: 16px 14px !important; font-size: 16px !important; font-weight: 700 !important; color: #1e3a8a !important; border-bottom: none !important; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 40px; display: flex; justify-content: space-between; align-items: center; }
        .footer p { font-size: 12px; color: #94a3b8; }
        .footer strong { color: #475569; }
        .print-btn { display: inline-flex; align-items: center; gap: 6px; background: #1e3a8a; color: #fff; border: none; cursor: pointer; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; }
        @media print {
            body { background: #fff; padding: 0; }
            .page { box-shadow: none; border-radius: 0; max-width: 100%; }
            .print-btn { display: none; }
            .footer { border-top: 1px solid #e2e8f0; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="header-top">
                <div>
                    <div class="logo">Tinggal<span>-</span>Klik</div>
                    <p style="font-size:12px;opacity:.7;margin-top:4px;">Marketplace Lapangan Olahraga</p>
                </div>
                <div class="invoice-label">
                    <p>INVOICE</p>
                    <h2>#{{ str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT) }}</h2>
                </div>
            </div>
            <div class="badge-lunas">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                LUNAS / PAID
            </div>
        </div>

        <div class="body">
            <p class="section-title">Detail Transaksi</p>
            <div class="info-grid">
                <div class="info-card">
                    <label>Pemesan</label>
                    <p>{{ $pemesanan->user->name ?? '-' }}</p>
                    <small>{{ $pemesanan->user->email ?? '' }}</small>
                </div>
                <div class="info-card">
                    <label>Lapangan</label>
                    <p>{{ $pemesanan->lapangan->nama_lapangan ?? '-' }}</p>
                    <small>{{ $pemesanan->lapangan->jenis_olahraga ?? '' }}</small>
                </div>
                <div class="info-card">
                    <label>Kode Transaksi</label>
                    <p style="font-size:12px;word-break:break-all;">{{ $pemesanan->transaction->kode_transaksi ?? '-' }}</p>
                </div>
                <div class="info-card">
                    <label>Tanggal Bayar</label>
                    <p>{{ \Carbon\Carbon::parse($pemesanan->updated_at)->isoFormat('D MMM Y') }}</p>
                    <small>{{ \Carbon\Carbon::parse($pemesanan->updated_at)->isoFormat('HH:mm') }} WIB</small>
                </div>
            </div>

            <hr class="divider">

            <p class="section-title">Rincian Sewa</p>
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align:right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $pemesanan->lapangan->nama_lapangan ?? 'Lapangan' }}</strong><br>
                            <span style="font-size:12px;color:#64748b;">
                                {{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->isoFormat('dddd, D MMMM Y') }}<br>
                                {{ substr($pemesanan->jam_mulai, 0, 5) }} – {{ substr($pemesanan->jam_selesai, 0, 5) }} WIB
                                ({{ $pemesanan->total_durasi }} jam)
                            </span>
                        </td>
                        <td>Rp {{ number_format($pemesanan->lapangan->harga_per_jam ?? 0, 0, ',', '.') }} × {{ $pemesanan->total_durasi }}</td>
                    </tr>
                    @if($pemesanan->transaction)
                    <tr>
                        <td><span style="font-size:12px;color:#94a3b8;">Platform Fee (2%)</span></td>
                        <td style="color:#64748b;font-weight:500;">Rp {{ number_format($pemesanan->transaction->platform_fee, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td style="border-radius:10px 0 0 10px;">TOTAL PEMBAYARAN</td>
                        <td style="border-radius:0 10px 10px 0;">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <hr class="divider" style="margin-top:28px;">

            <p style="font-size:12px;color:#94a3b8;text-align:center;line-height:1.7;">
                Dokumen ini merupakan bukti pembayaran resmi yang dikeluarkan oleh sistem Tinggal-Klik.<br>
                Simpan dokumen ini sebagai bukti sewa lapangan Anda.
            </p>
        </div>

        <div class="footer">
            <div>
                <p>Diterbitkan oleh <strong>Tinggal-Klik</strong></p>
                <p>{{ config('app.url') }}</p>
            </div>
            <button class="print-btn" onclick="window.print()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-6 0h-4v4h4v-4z"/></svg>
                Cetak Invoice
            </button>
        </div>
    </div>
</body>
</html>
