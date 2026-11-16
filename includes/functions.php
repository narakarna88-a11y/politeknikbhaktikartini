<?php
/**
 * Kumpulan fungsi bantuan (helper).
 */

// Escape output agar aman dari XSS
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// Redirect lalu hentikan eksekusi
function redirect($url) {
    header("Location: $url");
    exit;
}

// ==== Flash message (notifikasi sukses/gagal setelah redirect) ====
function set_flash($type, $msg) {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}
function get_flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

// ==== CSRF token sederhana ====
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}
function csrf_verify($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token ?? '');
}

/**
 * Upload gambar dengan validasi tipe & ukuran file.
 * $file   : array dari $_FILES['nama_input']
 * $folder : subfolder di dalam /uploads/ (mis. 'artikel', 'gallery', 'produk')
 * $old    : nama file lama (untuk mode edit, akan dihapus jika ada file baru)
 * $required : jika true dan tidak ada file baru & tidak ada file lama -> error
 *
 * Return: ['ok' => bool, 'filename' => string|null, 'msg' => string]
 */
function upload_gambar($file, $folder, $old = null, $required = false) {
    $uploadDir = __DIR__ . '/../uploads/' . $folder . '/';

    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        if ($required && !$old) {
            return ['ok' => false, 'filename' => null, 'msg' => 'Gambar wajib diunggah.'];
        }
        return ['ok' => true, 'filename' => $old, 'msg' => ''];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'filename' => null, 'msg' => 'Terjadi kesalahan saat mengunggah gambar.'];
    }

    $allowedExt  = ['jpg', 'jpeg', 'png', 'webp'];
    $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt) || !in_array($file['type'], $allowedMime)) {
        return ['ok' => false, 'filename' => null, 'msg' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.'];
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        return ['ok' => false, 'filename' => null, 'msg' => 'Ukuran gambar maksimal 2MB.'];
    }

    $newName = $folder . '_' . uniqid() . '.' . $ext;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        return ['ok' => false, 'filename' => null, 'msg' => 'Gagal menyimpan gambar ke server.'];
    }

    // Hapus file lama jika ada penggantian
    if ($old && $old !== $newName && file_exists($uploadDir . $old)) {
        @unlink($uploadDir . $old);
    }

    return ['ok' => true, 'filename' => $newName, 'msg' => ''];
}

// Hitung info pagination
function paginate_info($totalRows, $perPage, $page) {
    $totalPages = max(1, (int) ceil($totalRows / $perPage));
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;
    return ['page' => $page, 'totalPages' => $totalPages, 'offset' => $offset, 'totalRows' => (int) $totalRows];
}

// Render komponen navigasi pagination (dipakai front-end & admin)
function render_pagination($page, $totalPages, $baseUrl, $queryParams = []) {
    if ($totalPages <= 1) return '';
    $build = function ($p) use ($baseUrl, $queryParams) {
        $qp = array_merge($queryParams, ['page' => $p]);
        return $baseUrl . '?' . http_build_query($qp);
    };
    $html = '<nav class="flex items-center justify-center gap-2 mt-8" aria-label="Navigasi halaman">';
    $html .= $page > 1
        ? '<a href="' . h($build($page - 1)) . '" class="px-3 py-2 rounded-lg border border-pbk-border text-sm hover:bg-pbk-secondary">&laquo; Sebelumnya</a>'
        : '<span class="px-3 py-2 rounded-lg border border-pbk-border text-sm text-gray-300 cursor-not-allowed">&laquo; Sebelumnya</span>';

    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i === $page) {
            $html .= '<span class="px-3.5 py-2 rounded-lg bg-pbk-primary text-white text-sm font-semibold">' . $i . '</span>';
        } else {
            $html .= '<a href="' . h($build($i)) . '" class="px-3.5 py-2 rounded-lg border border-pbk-border text-sm hover:bg-pbk-secondary">' . $i . '</a>';
        }
    }

    $html .= $page < $totalPages
        ? '<a href="' . h($build($page + 1)) . '" class="px-3 py-2 rounded-lg border border-pbk-border text-sm hover:bg-pbk-secondary">Berikutnya &raquo;</a>'
        : '<span class="px-3 py-2 rounded-lg border border-pbk-border text-sm text-gray-300 cursor-not-allowed">Berikutnya &raquo;</span>';
    $html .= '</nav>';
    return $html;
}

function format_tanggal_indo($tanggal) {
    $bulan = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $ts = strtotime($tanggal);
    return date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}
