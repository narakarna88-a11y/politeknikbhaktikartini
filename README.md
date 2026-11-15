# Website Dinamis Politeknik Bhakti Kartini

Website ini merupakan hasil konversi dari versi statis (HTML) menjadi dinamis menggunakan **PHP native + MySQL**, dengan sistem login admin dan CRUD penuh.

## Fitur

**Front-End**
- Home — hero, statistik, dan 3 artikel terbaru (dinamis dari database)
- About — profil, visi/misi, pimpinan
- Services — daftar Program Studi/Layanan (dinamis dari database)
- Detail Produk — halaman detail per program studi/layanan
- Gallery — galeri foto dengan filter kategori + pagination (dinamis)
- Contact — form kontak dengan validasi server-side, tersimpan ke database

**Back-End (Admin)** — `/admin`
- Login (session-based, `password_hash()` / `password_verify()`)
- Dashboard — ringkasan jumlah data
- Data Admin — CRUD akun admin
- Artikel — CRUD + upload gambar
- Gallery — CRUD + upload gambar
- Produk/Layanan — CRUD + upload gambar
- Contact — lihat & hapus pesan masuk dari pengunjung
- Logout

Setiap halaman list admin dilengkapi **search**, **pagination**, dan **konfirmasi hapus** (dialog JavaScript). Setiap form dilengkapi **validasi server-side PHP**.

## Kebutuhan Server

- PHP 8.0 atau lebih baru (ekstensi `pdo_mysql` aktif)
- MySQL / MariaDB
- Web server: Apache/Nginx (atau XAMPP/Laragon untuk lokal)

## Langkah Instalasi

1. **Salin folder project** ini ke folder `htdocs` (XAMPP) atau `www` (Laragon), misalnya:
   `C:\xampp\htdocs\politeknikbhaktikartini`

2. **Buat database**: buka phpMyAdmin, buat database baru (atau import langsung), lalu import file `database.sql` yang ada di root folder ini. Ini akan membuat semua tabel (`admin`, `artikel`, `gallery`, `produk`, `pesan_kontak`) beserta data contoh.

3. **Sesuaikan koneksi database** di `includes/config.php` jika perlu (default: host `localhost`, database `pbk_db`, user `root`, password kosong — sesuai default XAMPP).

4. **Sesuaikan `BASE_URL`** di `includes/config.php` sesuai nama folder project Anda, misalnya:
   ```php
   define('BASE_URL', '/politeknikbhaktikartini');
   ```

5. **Buat akun admin pertama**: buka di browser
   `http://localhost/politeknikbhaktikartini/admin/setup.php`
   Isi nama, username, dan password — akan otomatis di-hash dengan `password_hash()`.
   **Setelah akun berhasil dibuat, hapus file `admin/setup.php`** demi keamanan (halaman ini akan otomatis terkunci sendiri jika tabel admin sudah terisi, tapi menghapusnya tetap disarankan).

6. **Login** di `http://localhost/politeknikbhaktikartini/admin/login.php`

7. Pastikan folder `uploads/artikel`, `uploads/gallery`, `uploads/produk` dapat ditulis oleh web server (writable/permission 755 atau 775 di Linux).

## Struktur Folder

```
politeknikbhaktikartini/
├── admin/                  # Back-End (butuh login)
│   ├── includes/           # auth.php, layout_top/bottom.php
│   ├── setup.php           # Setup akun admin pertama (hapus setelah dipakai)
│   ├── login.php / logout.php
│   ├── dashboard.php
│   ├── admin_data.php / admin_form.php
│   ├── artikel.php / artikel_form.php
│   ├── gallery.php / gallery_form.php
│   ├── produk.php / produk_form.php
│   └── contact.php
├── includes/                # config.php, functions.php, header.php, footer.php
├── uploads/                 # Folder hasil upload gambar (artikel/gallery/produk)
├── css/ , js/ , images/     # Aset asli (tidak diubah)
├── index.php, about.php, services.php, gallery.php, contact.php, produk_detail.php
└── database.sql
```

## Catatan Keamanan

- Password disimpan ter-hash dengan `password_hash()` (bcrypt), diverifikasi dengan `password_verify()`.
- Setiap form dilindungi token CSRF sederhana.
- Semua query database menggunakan **prepared statements (PDO)** untuk mencegah SQL Injection.
- Semua output ke HTML di-escape dengan `htmlspecialchars()` untuk mencegah XSS.
- Upload gambar divalidasi tipe file (jpg/jpeg/png/webp) dan ukuran maksimal 2MB.
