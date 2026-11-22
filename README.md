# Semoga Nyala — Sistem Informasi Reservasi Servis Laptop & PC

Aplikasi berbasis web untuk mempermudah pelanggan dalam melakukan reservasi perbaikan laptop maupun PC secara online, mendapatkan kode tiket unik, serta memantau progres servis secara *real-time*. Dilengkapi dengan dashboard admin berbasis papan Kanban untuk mengelola antrean perbaikan.

🌐 **Live Demo:** [http://semoganyala.infinityfreeapp.com](http://semoganyala.infinityfreeapp.com)

---

## Fitur Utama

### Halaman Pelanggan
- **Reservasi Servis Online:** Formulir pengajuan servis yang dilengkapi validasi nomor WhatsApp (JavaScript), pemilihan kategori layanan beserta estimasi biaya, jenis & merk perangkat, deskripsi keluhan, serta unggah foto kondisi perangkat (`JPG`/`PNG`/`WEBP`).
- **Halaman Konfirmasi Tiket & WhatsApp Admin:** Sistem otomatis membuat kode tiket unik (`TK-YYYYMMDD-XXXX`) dan menampilkan halaman konfirmasi keberhasilan lengkap dengan tombol salin cepat serta tombol kirim konfirmasi langsung ke WhatsApp Admin.
- **Lacak Status Tiket (`tracking.php`):** Pelanggan dapat mengecek status perbaikan perangkat dan pratinjau foto kondisi awal kapan saja menggunakan kode tiket tanpa perlu login.
- **Desain Responsif & Mode Gelap (Dark Mode):** Mendukung tampilan optimal di perangkat desktop maupun mobile (dengan menu navigasi *hamburger*) serta pergantian tema terang dan gelap pada halaman utama.

### Halaman Admin
- **Autentikasi & Keamanan:** Login admin menggunakan PHP `session`, verifikasi kata sandi terenkripsi (`password_hash` / `password_verify`), serta fitur *Remember Me* berbasis cookie selama 7 hari.
- **Dashboard Kanban 4 Status:** Pengelolaan tiket terkelompok berdasarkan status (**Pending**, **Proses**, **Selesai**, dan **Diambil**).
- **Notifikasi WhatsApp Pelanggan:** Tombol pintasan untuk mengirim pembaruan status servis langsung ke nomor WhatsApp pelanggan.
- **Manajemen Data (CRUD):** Admin dapat memperbarui status pengerjaan serta menghapus tiket beserta file foto fisiknya yang tersimpan di server.

---

## Teknologi yang Digunakan
- **Backend:** PHP Native (`MySQLi` Prepared Statements)
- **Frontend:** HTML5, Tailwind CSS (CDN), Vanilla JavaScript
- **Database:** MySQL / MariaDB (`db_service_laptop`)
- **Hosting:** InfinityFree

---

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
│   ├── simpan_reservasi.php   # Proses simpan reservasi, upload foto & konfirmasi WA
│   └── update_status.php      # Proses pembaruan status tiket
├── uploads/                   # Direktori penyimpanan foto kerusakan perangkat
├── index.php                  # Halaman utama & formulir reservasi pelanggan
├── tracking.php               # Halaman pelacakan status tiket servis
├── database.sql               # File struktur & data awal database MySQL
└── README.md                  # Dokumentasi proyek
```

---

## Cara Instalasi & Menjalankan Proyek (Lokal)

1. **Clone atau Unduh Repository**
   ```bash
   git clone [https://github.com/AbnerBgs/Sistem-Informasi-Reservasi-Laptop-Komputer.git](https://github.com/AbnerBgs/Sistem-Informasi-Reservasi-Laptop-Komputer.git)
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

---

## Anggota Kelompok
- **Abner Bagus** — NIM `123250014`
- **Nathan Narendrata** — NIM `123250076`