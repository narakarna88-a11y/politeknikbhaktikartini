<?php
require_once __DIR__ . '/includes/auth.php';

$totalArtikel = $pdo->query("SELECT COUNT(*) c FROM artikel")->fetch()['c'];
$totalGallery = $pdo->query("SELECT COUNT(*) c FROM gallery")->fetch()['c'];
$totalProduk  = $pdo->query("SELECT COUNT(*) c FROM produk")->fetch()['c'];
$totalAdmin   = $pdo->query("SELECT COUNT(*) c FROM admin")->fetch()['c'];
$totalPesan   = $pdo->query("SELECT COUNT(*) c FROM pesan_kontak")->fetch()['c'];
$pesanBaru    = $pdo->query("SELECT COUNT(*) c FROM pesan_kontak WHERE status = 'baru'")->fetch()['c'];

$pesanTerbaru = $pdo->query("SELECT * FROM pesan_kontak ORDER BY created_at DESC LIMIT 5")->fetchAll();

$pageTitle = 'Dashboard';
$activeMenu = 'dashboard';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
  <div class="bg-white border border-pbk-border rounded-2xl p-6">
    <div class="text-3xl font-display font-black text-pbk-primary"><?= (int) $totalArtikel ?></div>
    <div class="text-sm text-pbk-muted mt-1">Artikel</div>
  </div>
  <div class="bg-white border border-pbk-border rounded-2xl p-6">
    <div class="text-3xl font-display font-black text-pbk-primary"><?= (int) $totalGallery ?></div>
    <div class="text-sm text-pbk-muted mt-1">Foto Gallery</div>
  </div>
  <div class="bg-white border border-pbk-border rounded-2xl p-6">
    <div class="text-3xl font-display font-black text-pbk-primary"><?= (int) $totalProduk ?></div>
    <div class="text-sm text-pbk-muted mt-1">Produk / Layanan</div>
  </div>
  <div class="bg-white border border-pbk-border rounded-2xl p-6">
    <div class="text-3xl font-display font-black text-pbk-primary"><?= (int) $totalPesan ?></div>
    <div class="text-sm text-pbk-muted mt-1">Pesan Masuk <?php if ($pesanBaru > 0): ?><span class="text-pbk-accent">(<?= (int) $pesanBaru ?> baru)</span><?php endif; ?></div>
  </div>
</div>

<div class="bg-white border border-pbk-border rounded-2xl p-6">
  <div class="flex items-center justify-between mb-4">
    <h2 class="font-bold">Pesan Masuk Terbaru</h2>
    <a href="contact.php" class="text-sm font-semibold text-pbk-primary hover:underline">Lihat semua &rarr;</a>
  </div>
  <?php if (empty($pesanTerbaru)): ?>
    <p class="text-sm text-pbk-muted">Belum ada pesan masuk.</p>
  <?php else: ?>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left text-pbk-muted border-b border-pbk-border">
            <th class="py-2 pr-4">Nama</th>
            <th class="py-2 pr-4">Topik</th>
            <th class="py-2 pr-4">Tanggal</th>
            <th class="py-2 pr-4">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pesanTerbaru as $p): ?>
            <tr class="border-b border-pbk-border last:border-0">
              <td class="py-2.5 pr-4 font-medium"><?= h($p['nama']) ?></td>
              <td class="py-2.5 pr-4 text-pbk-muted"><?= h($p['topik']) ?></td>
              <td class="py-2.5 pr-4 text-pbk-muted"><?= h(date('d/m/Y', strtotime($p['created_at']))) ?></td>
              <td class="py-2.5 pr-4">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $p['status'] === 'baru' ? 'bg-pbk-accent/15 text-pbk-accent' : 'bg-gray-100 text-gray-500' ?>"><?= h(ucfirst($p['status'])) ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
