<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['admin_id'])) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Sesi tidak valid, silakan muat ulang halaman dan coba lagi.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $error = 'Username dan password wajib diisi.';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id']       = $admin['id'];
                $_SESSION['admin_nama']     = $admin['nama'];
                $_SESSION['admin_username'] = $admin['username'];
                redirect('dashboard.php');
            } else {
                $error = 'Username atau password salah.';
            }
        }
    }
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login Admin — Politeknik Bhakti Kartini</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: { colors: { pbk: { bg: "#f8f7f2", fg: "#0f1b2d", primary: "#0e3a6e", primarydark: "#082548", secondary: "#e8f0fb", accent: "#f5a623", muted: "#6b7280" } }, fontFamily: { display: ["Lora","serif"], sans: ["Plus Jakarta Sans","sans-serif"] } } } };
</script>
</head>
<body class="bg-pbk-bg text-pbk-fg font-sans min-h-screen flex items-center justify-center px-4 py-10">
  <div class="w-full max-w-md bg-white border border-pbk-border rounded-3xl shadow-xl p-8">
    <div class="text-center mb-6">
      <img src="../images/logo.png" alt="Logo Politeknik Bhakti Kartini" class="w-14 h-14 mx-auto rounded-full object-contain mb-3" />
      <h1 class="font-display font-black text-2xl">Login Admin</h1>
      <p class="text-sm text-pbk-muted mt-1">Politeknik Bhakti Kartini — Panel Administrator</p>
    </div>

    <?php if ($flash): ?>
      <div class="mb-5 rounded-xl <?= $flash['type'] === 'success' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-700' ?> border text-sm px-4 py-3">
        <?= h($flash['msg']) ?>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
        <?= h($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" novalidate class="space-y-4">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm font-semibold mb-1.5">Username</label>
        <input type="text" name="username" value="<?= h($_POST['username'] ?? '') ?>" required autofocus class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1.5">Password</label>
        <input type="password" name="password" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <button type="submit" class="w-full bg-pbk-primary text-white font-semibold py-3 rounded-xl hover:bg-pbk-primarydark transition-colors">Masuk</button>
    </form>

    <p class="text-center text-xs text-pbk-muted mt-6">
      <a href="../index.php" class="hover:text-pbk-primary">&larr; Kembali ke website</a>
    </p>
  </div>
</body>
</html>
