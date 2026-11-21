# Semoga Nyala — Sistem Informasi Reservasi Servis Laptop & PC

Aplikasi berbasis web untuk mempermudah pelanggan dalam melakukan reservasi perbaikan laptop maupun PC secara online, mendapatkan kode tiket unik, serta memantau progres servis secara real-time. Dilengkapi dengan dashboard admin berbasis Kanban untuk mengelola antrean perbaikan.

## Fitur Utama

### Halaman Pelanggan
- **Reservasi Servis Online:** Formulir pengajuan servis yang dilengkapi pemilihan kategori layanan, jenis & merk perangkat, deskripsi keluhan, serta unggah foto kerusakan (JPG/PNG/WEBP).
- **Kode Tiket Otomatis & Konfirmasi WhatsApp:** Sistem otomatis membuat kode tiket unik (`TK-YYYYMMDD-XXXX`) dan mengarahkan pelanggan untuk konfirmasi langsung ke WhatsApp Admin.
- **Lacak Status Tiket (`tracking.php`):** Pelanggan dapat mengecek status perbaikan perangkat kapan saja menggunakan kode tiket tanpa perlu login.
- **Mode Gelap (Dark Mode):** Mendukung pergantian tema terang dan gelap pada halaman utama.

### Halaman Admin
- **Autentikasi & Keamanan:** Login admin menggunakan PHP `session`, verifikasi password terenkripsi (`password_hash` / `password_verify`), serta fitur *Remember Me* berbasis cookie selama 7 hari.
- **Dashboard Kanban 4 Status:** Pengelolaan tiket terkelompok berdasarkan status (**Pending**, **Proses**, **Selesai**, dan **Diambil**).
- **Notifikasi WhatsApp Pelanggan:** Tombol pintasan untuk mengirim pembaruan status servis langsung ke nomor WhatsApp pelanggan.
- **Manajemen Data (CRUD):** Admin dapat memperbarui status pengerjaan serta menghapus tiket beserta file foto yang tersimpan di server.

## Teknologi yang Digunakan
- **Backend:** PHP Native (MySQLi Prepared Statements)
- **Frontend:** HTML5, Tailwind CSS (CDN), Vanilla JavaScript
- **Database:** MySQL / MariaDB (`db_service_laptop`)

## Struktur Folder
```text
reservasi-laptop/
├── admin/
│   ├── dashboard.php          # Dashboard Kanban kelola tiket servis
│   ├── login.php              # Halaman & proses autentikasi admin
│   └── logout.php             # Proses penghapusan session admin
├── config/
│   └── koneksi.php            # Konfigurasi koneksi database MySQL
├── proses/
│   ├── hapus_tiket.php        # Proses hapus data tiket & file foto
│   ├── simpan_reservasi.php   # Proses simpan reservasi, upload foto & redirect WA
│   └── update_status.php      # Proses pembaruan status tiket
├── uploads/                   # Direktori penyimpanan foto kerusakan perangkat
├── index.php                  # Halaman utama & formulir reservasi pelanggan
├── tracking.php               # Halaman pelacakan status tiket servis
├── database.sql               # File struktur & data awal database MySQL
└── README.md                  # Dokumentasi proyek
```

## Cara Instalasi & Menjalankan Proyek

1. **Clone atau Unduh Repository**
   ```bash
   git clone [https://github.com/AbnerBgs/Sistem-Informasi-Reservasi-Laptop-Komputer.git]
   ```
   Pindahkan folder proyek ke dalam direktori web server lokal (misalnya `C:\xampp\htdocs\`).

2. **Konfigurasi Database**
   - Jalankan layanan **Apache** dan **MySQL** pada XAMPP / Laragon.
   - Buka **phpMyAdmin** (`http://localhost/phpmyadmin`), lalu buat database baru bernama **`db_service_laptop`**.
   - Pilih database `db_service_laptop`, masuk ke tab **Import**, lalu unggah file **`database.sql`** yang tersedia di repository ini.

3. **Sesuaikan Koneksi (Opsional)**
   Pastikan pengaturan host, username, password, dan nama database di file `config/koneksi.php` sudah sesuai dengan server lokal Anda:
   ```php
   $conn = mysqli_connect("localhost", "root", "", "db_service_laptop");
   ```

4. **Jalankan Aplikasi**
   - **Halaman Pelanggan:** `http://localhost/reservasi-laptop/index.php`
   - **Halaman Tracking:** `http://localhost/reservasi-laptop/tracking.php`
   - **Halaman Login Admin:** `http://localhost/reservasi-laptop/admin/login.php`

## Anggota Kelompok
- **Abner Bagas** — NIM `123250014`
- **Nathan Narendrata** — NIM `123250076`