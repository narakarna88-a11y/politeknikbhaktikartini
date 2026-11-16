<?php
/**
 * Dipakai oleh setiap halaman admin.
 * Wajib set $pageTitle dan $activeMenu SEBELUM include file ini.
 */
$flash = get_flash();
$menus = [
    'dashboard' => ['label' => 'Dashboard',       'url' => 'dashboard.php',   'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
    'admin'     => ['label' => 'Data Admin',       'url' => 'admin_data.php', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    'artikel'   => ['label' => 'Artikel',          'url' => 'artikel.php',    'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2zM13 4v6h6'],
    'gallery'   => ['label' => 'Gallery',          'url' => 'gallery.php',    'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
    'produk'    => ['label' => 'Produk/Layanan',   'url' => 'produk.php',     'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375C2.754 3.75 2.25 4.254 2.25 4.875v1.5c0 .621.504 1.125 1.125 1.125z'],
    'contact'   => ['label' => 'Contact',          'url' => 'contact.php',    'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= h($pageTitle) ?> — Admin Politeknik Bhakti Kartini</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: { colors: { pbk: { bg: "#f8f7f2", fg: "#0f1b2d", primary: "#0e3a6e", primarydark: "#082548", secondary: "#e8f0fb", accent: "#f5a623", muted: "#6b7280", border: "#e5e0d5" } }, fontFamily: { display: ["Lora","serif"], sans: ["Plus Jakarta Sans","sans-serif"] } } } };
</script>
</head>
<body class="bg-pbk-bg text-pbk-fg font-sans antialiased">
<div class="min-h-screen flex">

  <!-- ================= SIDEBAR ================= -->
  <aside class="w-64 bg-pbk-primary text-white flex-shrink-0 hidden lg:flex flex-col">
    <div class="h-20 flex items-center gap-3 px-6 border-b border-white/10">
      <img src="../images/logo.png" alt="Logo" class="w-9 h-9 rounded-full object-contain" />
      <div class="leading-tight">
        <div class="font-display font-bold text-sm">PBK Admin</div>
        <div class="text-xs text-white/60">Panel Pengelola</div>
      </div>
    </div>
    <nav class="flex-1 py-6 px-3 space-y-1">
      <?php foreach ($menus as $key => $m): ?>
        <a href="<?= h($m['url']) ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors <?= $activeMenu === $key ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' ?>">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="<?= $m['icon'] ?>"/></svg>
          <?= h($m['label']) ?>
        </a>
      <?php endforeach; ?>
      <div class="pt-3 mt-3 border-t border-white/10">
        <a href="logout.php" onclick="return confirm('Yakin ingin logout?');" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-colors">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
          Logout
        </a>
      </div>
    </nav>
  </aside>

  <!-- ================= MAIN ================= -->
  <div class="flex-1 flex flex-col min-w-0">
    <header class="h-20 bg-white border-b border-pbk-border flex items-center justify-between px-5 sm:px-8">
      <h1 class="font-display font-bold text-lg sm:text-xl"><?= h($pageTitle) ?></h1>
      <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
          <div class="text-sm font-semibold"><?= h($_SESSION['admin_nama'] ?? '') ?></div>
          <div class="text-xs text-pbk-muted">@<?= h($_SESSION['admin_username'] ?? '') ?></div>
        </div>
        <div class="w-10 h-10 rounded-full bg-pbk-secondary text-pbk-primary flex items-center justify-center font-bold">
          <?= h(strtoupper(substr($_SESSION['admin_nama'] ?? 'A', 0, 1))) ?>
        </div>
      </div>
    </header>

    <main class="flex-1 p-5 sm:p-8">
      <?php if ($flash): ?>
        <div class="mb-6 rounded-xl <?= $flash['type'] === 'success' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-700' ?> border text-sm px-4 py-3">
          <?= h($flash['msg']) ?>
        </div>
      <?php endif; ?>
