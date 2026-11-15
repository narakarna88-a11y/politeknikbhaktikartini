-- =========================================================
-- DATABASE: pbk_db
-- Website Dinamis Politeknik Bhakti Kartini
-- =========================================================

CREATE DATABASE IF NOT EXISTS pbk_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pbk_db;

-- ================= TABEL ADMIN =================
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel admin sengaja dibiarkan kosong.
-- Setelah import database ini, buka: http://localhost/politeknikbhaktikartini/admin/setup.php
-- untuk membuat akun admin pertama (password akan di-hash otomatis oleh password_hash()).
-- Hapus file admin/setup.php setelah akun admin pertama berhasil dibuat, demi keamanan.

-- ================= TABEL ARTIKEL =================
CREATE TABLE artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    ringkasan TEXT,
    isi TEXT,
    gambar VARCHAR(255),
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO artikel (judul, kategori, ringkasan, isi, gambar, tanggal) VALUES
('Mahasiswa Prodi Farmasi Raih Juara 1 Lomba Inovasi Obat Herbal Nasional', 'Prestasi', 'Tim mahasiswa D3 Farmasi membawa pulang trofi juara pertama tingkat nasional di Bandung.', 'Tim mahasiswa D3 Farmasi Politeknik Bhakti Kartini berhasil meraih juara 1 dalam ajang Lomba Inovasi Obat Herbal Nasional yang diselenggarakan di Bandung. Prestasi ini menjadi bukti nyata kualitas pendidikan dan riset di lingkungan kampus.', 'hhhtt.png', '2026-07-10'),
('Penerimaan Mahasiswa Baru 2026/2027 Resmi Dibuka', 'PMB', 'Pendaftaran gelombang pertama dibuka hingga 31 Agustus 2026. Tersedia beasiswa prestasi.', 'Politeknik Bhakti Kartini resmi membuka pendaftaran mahasiswa baru tahun ajaran 2026/2027. Pendaftaran gelombang pertama berlangsung hingga 31 Agustus 2026 dan tersedia program beasiswa bagi calon mahasiswa berprestasi.', 'download.jpg', '2026-07-05'),
('Wisuda Angkatan XII — 198 Lulusan Siap Memasuki Dunia Kerja', 'Kegiatan', '198 mahasiswa diwisuda dengan tingkat penyerapan kerja 87% dalam 3 bulan pertama.', 'Sebanyak 198 mahasiswa Politeknik Bhakti Kartini resmi diwisuda pada acara Wisuda Angkatan XII. Tingkat penyerapan kerja lulusan tercatat mencapai 87% dalam 3 bulan pertama setelah kelulusan.', 'OIP (1).webp', '2026-06-28');

-- ================= TABEL GALLERY =================
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO gallery (judul, kategori, gambar) VALUES
('Perpustakaan digital kampus', 'fasilitas', '11-1-768x432 - Copy.png'),
('Laboratorium farmasi', 'fasilitas', 'Poltek-Bhani-Foto-Kegiatan-ARS-1024x576.png'),
('Ruang kuliah modern', 'akademik', '57ac1af5-71be-4acf-af70-33703598b06b.jpg'),
('Studio multimedia', 'fasilitas', '14-1-768x432 - Copy.png'),
('Diskusi kelompok mahasiswa', 'kegiatan', '389ad1cc-86e0-4de3-b270-eedf7407abb9.jpg'),
('Prosesi wisuda mahasiswa', 'wisuda', '57ac1af5-71be-4acf-af70-33703598b06b.jpg'),
('Mahasiswa menerima penghargaan lomba', 'kegiatan', 'logistik.png');

-- ================= TABEL PRODUK / LAYANAN (Program Studi) =================
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    jenjang VARCHAR(50) NOT NULL,
    deskripsi TEXT,
    detail TEXT,
    gambar VARCHAR(255),
    semester INT DEFAULT 0,
    sks INT DEFAULT 0,
    akreditasi VARCHAR(5) DEFAULT '-',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO produk (nama, jenjang, deskripsi, detail, gambar, semester, sks, akreditasi) VALUES
('Teknologi Rekayasa Multimedia', 'D4 - Sarjana Terapan', 'Program sarjana terapan yang membekali mahasiswa dengan keahlian produksi konten digital, animasi, desain grafis, dan pengembangan media interaktif untuk industri kreatif masa kini.', 'Kompetensi utama: Animasi 2D/3D & motion graphics, Produksi video & sinematografi, Desain UI/UX & media interaktif.', '14-1-768x432 - Copy.png', 8, 144, 'A'),
('Administrasi Rumah Sakit', 'D3 - Ahli Madya', 'Mencetak tenaga ahli madya administrasi rumah sakit yang kompeten dalam manajemen rekam medis, pelayanan pasien, dan sistem informasi kesehatan.', 'Kompetensi utama: Manajemen rekam medis, Pelayanan administrasi pasien, Sistem informasi kesehatan.', '10-1-768x432.png', 6, 112, 'B'),
('Manajemen Logistik', 'D3 - Ahli Madya', 'Mempersiapkan profesional di bidang rantai pasok, pergudangan, distribusi barang, dan optimasi sistem logistik modern untuk mendukung efisiensi industri.', 'Kompetensi utama: Manajemen rantai pasok (SCM), Manajemen pergudangan, Sistem transportasi & distribusi.', '12-1-768x432 - Copy.png', 6, 112, 'B'),
('Farmasi', 'D3 - Ahli Madya', 'Menghasilkan ahli madya farmasi yang terampil dalam pelayanan kefarmasian, produksi obat, dan pengawasan mutu di industri farmasi maupun apotek.', 'Kompetensi utama: Farmakologi & farmasetika dasar, Praktik kerja di apotek & industri, Pengawasan mutu obat & herbal.', 'logistik.png', 6, 110, 'A');

-- ================= TABEL PESAN KONTAK =================
CREATE TABLE pesan_kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telepon VARCHAR(30),
    topik VARCHAR(50),
    pesan TEXT NOT NULL,
    status ENUM('baru','dibaca') DEFAULT 'baru',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
