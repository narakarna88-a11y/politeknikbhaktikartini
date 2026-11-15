<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    $pageTitle = 'Produk Tidak Ditemukan';
    $activeNav = 'services';
    require __DIR__ . '/includes/header.php';
    ?>
    <div class="max-w-3xl mx-auto px-5 sm:px-8 py-24 text-center">
      <h1 class="font-display font-black text-3xl mb-4">Program Tidak Ditemukan</h1>
      <p class="text-pbk-muted mb-8">Program studi/layanan yang Anda cari tidak tersedia atau sudah dihapus.</p>
      <a href="<?= BASE_URL ?>/services.php" class="inline-flex items-center gap-2 bg-pbk-primary text-white font-semibold px-6 py-3 rounded-full hover:bg-pbk-primarydark transition-colors">&larr; Kembali ke Program Studi</a>
    </div>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

$produkLain = $pdo->prepare("SELECT * FROM produk WHERE id != ? ORDER BY RAND() LIMIT 3");
$produkLain->execute([$id]);
$produkLain = $produkLain->fetchAll();

$pageTitle = $produk['nama'];
$pageDescription = $produk['deskripsi'];
$activeNav = 'services';
require __DIR__ . '/includes/header.php';
?>

  <!-- ================= HERO DETAIL ================= -->
  <section class="relative overflow-hidden paper-texture py-14 sm:py-16">
    <div class="max-w-5xl mx-auto px-5 sm:px-8 relative reveal">
      <nav class="text-xs text-pbk-muted mb-4">
        <a href="<?= BASE_URL ?>/services.php" class="hover:text-pbk-primary">Program Studi</a> / <span class="text-pbk-fg"><?= h($produk['nama']) ?></span>
      </nav>
      <span class="badge-ribbon text-pbk-accent text-xs font-bold uppercase tracking-wider">Jenjang <?= h($produk['jenjang']) ?></span>
      <h1 class="font-display font-black text-3xl sm:text-5xl mt-4 mb-4"><?= h($produk['nama']) ?></h1>
      <p class="text-pbk-muted text-lg leading-relaxed max-w-2xl"><?= h($produk['deskripsi']) ?></p>
    </div>
  </section>

  <!-- ================= DETAIL ================= -->
  <section class="pb-20">
    <div class="max-w-5xl mx-auto px-5 sm:px-8">
      <div class="rounded-3xl overflow-hidden shadow-xl aspect-[16/8] mb-10 reveal">
        <img src="<?= BASE_URL ?>/uploads/produk/<?= h($produk['gambar']) ?>" onerror="this.src='<?= BASE_URL ?>/images/logo.png'" alt="<?= h($produk['nama']) ?>" class="w-full h-full object-cover" loading="lazy" />
      </div>

      <div class="grid lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 reveal reveal-delay-1">
          <h2 class="font-display font-bold text-2xl mb-4">Tentang Program Ini</h2>
          <p class="text-pbk-muted leading-relaxed mb-6 whitespace-pre-line"><?= nl2br(h($produk['detail'] ?: $produk['deskripsi'])) ?></p>
        </div>
        <div class="reveal reveal-delay-2">
          <div class="bg-white border border-pbk-border rounded-2xl p-6 sticky top-28">
            <h3 class="font-bold mb-4">Informasi Program</h3>
            <ul class="space-y-3 text-sm">
              <li class="flex justify-between"><span class="text-pbk-muted">Jenjang</span><span class="font-semibold"><?= h($produk['jenjang']) ?></span></li>
              <li class="flex justify-between"><span class="text-pbk-muted">Semester</span><span class="font-semibold"><?= (int) $produk['semester'] ?></span></li>
              <li class="flex justify-between"><span class="text-pbk-muted">SKS</span><span class="font-semibold"><?= (int) $produk['sks'] ?></span></li>
              <li class="flex justify-between"><span class="text-pbk-muted">Akreditasi</span><span class="font-semibold"><?= h($produk['akreditasi']) ?></span></li>
            </ul>
            <a href="<?= BASE_URL ?>/contact.php#pmb" class="mt-6 block text-center bg-pbk-primary text-white font-semibold px-6 py-3 rounded-full hover:bg-pbk-primarydark transition-colors">Daftar Program Ini</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= PROGRAM LAIN ================= -->
  <?php if (!empty($produkLain)): ?>
  <section class="py-16 bg-pbk-secondary/50">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
      <h2 class="font-display font-black text-2xl sm:text-3xl mb-8 reveal">Program Studi Lainnya</h2>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($produkLain as $pl): ?>
          <a href="<?= BASE_URL ?>/produk_detail.php?id=<?= (int) $pl['id'] ?>" class="pbk-card reveal bg-white rounded-2xl overflow-hidden border border-pbk-border block">
            <img src="<?= BASE_URL ?>/uploads/produk/<?= h($pl['gambar']) ?>" onerror="this.src='<?= BASE_URL ?>/images/logo.png'" alt="<?= h($pl['nama']) ?>" class="w-full h-40 object-cover" loading="lazy" />
            <div class="p-5">
              <div class="text-xs font-bold text-pbk-accent uppercase mb-1">Jenjang <?= h($pl['jenjang']) ?></div>
              <h3 class="font-bold leading-snug"><?= h($pl['nama']) ?></h3>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
