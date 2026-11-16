<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Halaman ini hanya bisa diakses jika tabel admin masih kosong.
// Setelah akun admin pertama dibuat, halaman ini otomatis terkunci.
$jumlahAdmin = $pdo->query("SELECT COUNT(*) AS total FROM admin")->fetch()['total'];

if ($jumlahAdmin > 0) {
    die('Setup sudah pernah dilakukan. Akun admin sudah ada. Silakan hapus file admin/setup.php ini demi keamanan, lalu login melalui <a href="login.php">halaman login</a>.');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Sesi tidak valid, silakan muat ulang halaman.';
    } else {
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $konfirmasi = $_POST['konfirmasi'] ?? '';

        if ($nama === '') $errors[] = 'Nama wajib diisi.';
        if ($username === '') $errors[] = 'Username wajib diisi.';
        if (!preg_match('/^[a-zA-Z0-9_]{4,50}$/', $username)) $errors[] = 'Username 4-50 karakter, hanya huruf/angka/underscore.';
        if (strlen($password) < 6) $errors[] = 'Password minimal 6 karakter.';
        if ($password !== $konfirmasi) $errors[] = 'Konfirmasi password tidak cocok.';

        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin (nama, username, password) VALUES (?, ?, ?)");
            $stmt->execute([$nama, $username, $hash]);
            set_flash('success', 'Akun admin berhasil dibuat. Silakan login. Jangan lupa hapus file admin/setup.php.');
            redirect('login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Setup Akun Admin — Politeknik Bhakti Kartini</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: { colors: { pbk: { bg: "#f8f7f2", fg: "#0f1b2d", primary: "#0e3a6e", primarydark: "#082548", secondary: "#e8f0fb", accent: "#f5a623", muted: "#6b7280" } }, fontFamily: { display: ["Lora","serif"], sans: ["Plus Jakarta Sans","sans-serif"] } } } };
</script>
</head>
<body class="bg-pbk-bg text-pbk-fg font-sans min-h-screen flex items-center justify-center px-4 py-10">
  <div class="w-full max-w-md bg-white border border-pbk-border rounded-3xl shadow-xl p-8">
    <div class="text-center mb-6">
      <img src="../images/logo.png" alt="Logo" class="w-14 h-14 mx-auto rounded-full object-contain mb-3" />
      <h1 class="font-display font-black text-2xl">Setup Akun Admin</h1>
      <p class="text-sm text-pbk-muted mt-1">Buat akun administrator pertama untuk mengelola website.</p>
    </div>

    <?php if (!empty($errors)): ?>
      <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
        <ul class="list-disc list-inside space-y-1">
          <?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" novalidate class="space-y-4">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm font-semibold mb-1.5">Nama Lengkap</label>
        <input type="text" name="nama" value="<?= h($_POST['nama'] ?? '') ?>" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1.5">Username</label>
        <input type="text" name="username" value="<?= h($_POST['username'] ?? '') ?>" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1.5">Password</label>
        <input type="password" name="password" required minlength="6" class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1.5">Konfirmasi Password</label>
        <input type="password" name="konfirmasi" required minlength="6" class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <button type="submit" class="w-full bg-pbk-primary text-white font-semibold py-3 rounded-xl hover:bg-pbk-primarydark transition-colors">Buat Akun Admin</button>
    </form>
  </div>
</body>
</html>
