<?php
/**
 * Konfigurasi utama aplikasi.
 * Sesuaikan DB_HOST, DB_NAME, DB_USER, DB_PASS dengan pengaturan server Anda (XAMPP/Laragon/dsb).
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==== Sesuaikan BASE_URL dengan nama folder project di htdocs/www Anda ====
// Contoh: jika project ada di http://localhost/politeknikbhaktikartini
define('BASE_URL', '/politeknikbhaktikartini');
define('ADMIN_URL', BASE_URL . '/admin');

// ==== Konfigurasi Database ====
define('DB_HOST', 'localhost');
define('DB_NAME', 'pbk_db');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Koneksi database gagal. Pastikan database "pbk_db" sudah dibuat (import database.sql). Detail: ' . $e->getMessage());
}
