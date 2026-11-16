<?php
require_once __DIR__ . '/includes/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$isEdit = $id !== null;
$row = ['nama' => '', 'username' => ''];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        set_flash('error', 'Data admin tidak ditemukan.');
        redirect('admin_data.php');
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Sesi tidak valid, silakan coba lagi.';
    } else {
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $konfirmasi = $_POST['konfirmasi'] ?? '';

        if ($nama === '') $errors[] = 'Nama wajib diisi.';
        if (!preg_match('/^[a-zA-Z0-9_]{4,50}$/', $username)) $errors[] = 'Username 4-50 karakter, hanya huruf/angka/underscore.';

        // Cek duplikat username
        $checkStmt = $pdo->prepare("SELECT id FROM admin WHERE username = ?" . ($isEdit ? " AND id != ?" : ""));
        $checkParams = $isEdit ? [$username, $id] : [$username];
        $checkStmt->execute($checkParams);
        if ($checkStmt->fetch()) $errors[] = 'Username sudah digunakan, silakan pilih yang lain.';

        if (!$isEdit && strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter.';
        }
        if ($password !== '' && strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter.';
        }
        if ($password !== '' && $password !== $konfirmasi) {
            $errors[] = 'Konfirmasi password tidak cocok.';
        }

        if (empty($errors)) {
            if ($isEdit) {
                if ($password !== '') {
                    $stmt = $pdo->prepare("UPDATE admin SET nama = ?, username = ?, password = ? WHERE id = ?");
                    $stmt->execute([$nama, $username, password_hash($password, PASSWORD_DEFAULT), $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE admin SET nama = ?, username = ? WHERE id = ?");
                    $stmt->execute([$nama, $username, $id]);
                }
                // Sinkronkan session jika mengubah akun sendiri
                if ($id === (int) $_SESSION['admin_id']) {
                    $_SESSION['admin_nama'] = $nama;
                    $_SESSION['admin_username'] = $username;
                }
                set_flash('success', 'Data admin berhasil diperbarui.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO admin (nama, username, password) VALUES (?, ?, ?)");
                $stmt->execute([$nama, $username, password_hash($password, PASSWORD_DEFAULT)]);
                set_flash('success', 'Admin baru berhasil ditambahkan.');
            }
            redirect('admin_data.php');
        }
        $row['nama'] = $nama;
        $row['username'] = $username;
    }
}

$pageTitle = $isEdit ? 'Edit Admin' : 'Tambah Admin';
$activeMenu = 'admin';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="max-w-xl bg-white border border-pbk-border rounded-2xl p-6 sm:p-8">
  <?php if (!empty($errors)): ?>
    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
      <ul class="list-disc list-inside space-y-1"><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul>
    </div>
  <?php endif; ?>

  <form method="POST" novalidate class="space-y-5">
    <?= csrf_field() ?>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Nama Lengkap</label>
      <input type="text" name="nama" value="<?= h($row['nama']) ?>" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Username</label>
      <input type="text" name="username" value="<?= h($row['username']) ?>" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Password <?= $isEdit ? '<span class="text-pbk-muted font-normal">(kosongkan jika tidak ingin mengubah)</span>' : '' ?></label>
      <input type="password" name="password" class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Konfirmasi Password</label>
      <input type="password" name="konfirmasi" class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    </div>
    <div class="flex gap-3 pt-2">
      <button type="submit" class="bg-pbk-primary text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-pbk-primarydark transition-colors">Simpan</button>
      <a href="admin_data.php" class="px-6 py-2.5 rounded-xl border border-pbk-border text-sm font-semibold hover:bg-pbk-secondary transition-colors">Batal</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
