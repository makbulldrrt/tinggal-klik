# Tinggal Klik - Sistem Booking Lapangan Olahraga

Sistem manajemen dan penyewaan lapangan olahraga (GOR) berbasis web yang dirancang untuk mendigitalisasi pencatatan jadwal, mengeliminasi risiko bentrok pengisian (*double-booking*), serta mengotomatisasi proses verifikasi pembayaran. Proyek ini dikembangkan oleh **Tim KBR Kelompok 6** sebagai solusi modern bagi pengelola sarana olahraga dan pelanggan.

## Arsitektur & Fitur Utama

*   **Pencegahan Race Condition (Anti-Double Booking):** Menggunakan kombinasi penguncian status di sisi *frontend* (grid waktu interaktif) dan validasi transaksi atomik di sisi *backend* untuk memastikan tidak ada dua pengguna yang dapat memesan slot jam yang sama pada tanggal yang sama.
*   **Otomatisasi Webhook Pembayaran:** Integrasi dengan *Payment Gateway* Midtrans (Sandbox Environment). Perubahan status pembayaran dari `belum_bayar` menjadi `lunas` diproses secara otomatis melalui *callback/webhook* tanpa intervensi manual dari admin atau owner.
*   **Peta Interaktif & Geolokasi:** Integrasi Leaflet.js untuk pemetaan lokasi GOR secara presisi berbasis koordinat lintang/bujur (Latitude/Longitude) yang terhubung langsung dengan Google Maps untuk kemudahan rute.
*   **Autentikasi & Kontrol Akses Multi-Role:** Pembagian hak akses terproteksi berbasis Laravel Middleware:
    *   **Admin:** Monitoring metrik platform, manajemen pengguna, dan penanganan data master.
    *   **Owner GOR:** Manajemen operasional lapangan, pemantauan riwayat transaksi masuk, dan pengajuan penarikan dana (*withdrawal*).
    *   **Pelanggan:** Eksplorasi katalog GOR, pemesanan slot jadwal, dan manajemen riwayat ulasan/rating.
*   **REST API Terproteksi:** Penyediaan endpoint data berformat JSON murni untuk integrasi eksternal, diamankan menggunakan Laravel Sanctum.

## Tech Stack

*   **Core Framework:** Laravel 11 (PHP 8.2+)
*   **Database Engine:** MySQL / phpmyadmin
*   **Frontend Engine:** Blade Templating, TailwindCSS, Vanilla JavaScript (ES6)
*   **Library & API:** Leaflet.js, Midtrans Core API
*   **Tools Pengujian:** Postman

## Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan repositori ini di lingkungan lokal Anda:

### 1. Kloning Repositori
```bash
git clone https://github.com/makbuildrrt/tinggal-klik.git
cd tinggal-klik
```

### 2. Pemasangan Dependensi
Pastikan PHP 8.2+ dan Node.js sudah terinstal di sistem Anda, kemudian jalankan:
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
Salin berkas `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka berkas `.env` baru tersebut, lalu sesuaikan kredensial database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tinggal_klik
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan Pengujian Registrasi:** Untuk menghindari kegagalan *timeout* saat mengirim email verifikasi akun baru di lokal, ubah driver mailer menjadi mode log. Seluruh tautan verifikasi akan otomatis tercatat di berkas `storage/logs/laravel.log`.
```env
MAIL_MAILER=log
```

### 4. Inisialisasi Aplikasi & Database
Generate key aplikasi, pasang API guard, dan jalankan migrasi beserta data seeder awal:
```bash
php artisan key:generate
php artisan install:api
php artisan migrate:fresh --seed
```

### 5. Menjalankan Server
Buka dua tab terminal terpisah untuk menjalankan compiler frontend dan server lokal Laravel:

*   **Terminal 1:** `npm run dev`
*   **Terminal 2:** `php artisan serve`

Aplikasi dapat diakses penuh melalui peramban di alamat `http://127.0.0.1:8000`.

## Dokumentasi REST API

Seluruh endpoint API mengembalikan data dalam format **JSON murni**. Query pengumpulan data dioptimalkan menggunakan teknik *Eager Loading* untuk mencegah masalah *N+1 query*.

### Ringkasan Endpoint

| Method | Endpoint URL | Otentikasi | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/lapangan` | Publik | Mengambil semua daftar katalog lapangan aktif. |
| `GET` | `/api/lapangan/{id}` | Publik | Mengambil objek detail lengkap dari satu lapangan. |
| `GET` | `/api/ulasan` | Publik | Mengambil data ulasan beserta objek relasi data `user`. |
| `POST` | `/api/lapangan` | Sanctum | Menambahkan data lapangan baru (Khusus Role Owner/Admin). |

### Contoh Respons JSON (`GET /api/ulasan`)
```json
[
  {
    "id": 1,
    "user_id": 1,
    "lapangan_id": 1,
    "rating": 5,
    "komentar": "Tempatnya sangat bersih, pencahayaan lapangan futsalnya sangat bagus untuk main malam hari!",
    "created_at": "2026-07-14T16:16:16.000000Z",
    "updated_at": "2026-07-14T16:16:16.000000Z",
    "user": {
      "id": 1,
      "name": "Makbul Darojat",
      "email": "makbul@tinggalklik.com",
      "role": "pelanggan"
    }
  }
]
```

## Tim Pengembang (KBR Kelompok 6)

*   **Makbul Darojat** - Project Manager, QA, QC, Fullstack
*   **Ahmad Mahdi** - Frontend Integration
*   **Raihan Hafidz** - Database Administrator
*   **Decky** - Backend Developer
