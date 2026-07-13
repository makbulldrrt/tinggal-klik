@component('mail::message')
# Invoice Pemesanan #{{ $pemesanan->id }}

Terima kasih telah melakukan pemesanan di **Tinggal-Klik**.

@component('mail::panel')
**Lapangan:** {{ $pemesanan->lapangan->nama_lapangan ?? '-' }}
**Tanggal:** {{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->isoFormat('dddd, D MMMM Y') }}
**Waktu:** {{ substr($pemesanan->jam_mulai, 0, 5) }} – {{ substr($pemesanan->jam_selesai, 0, 5) }} WIB
**Durasi:** {{ $pemesanan->total_durasi }} jam
**Total Bayar:** Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
**Status:** Lunas ✓
@endcomponent

@component('mail::button', ['url' => url('/booking/history'), 'color' => 'primary'])
Lihat Riwayat Pemesanan
@endcomponent

Salam,
Tim **Tinggal-Klik**
@endcomponent
