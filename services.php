<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$produkList = $pdo->query("SELECT * FROM produk ORDER BY id ASC")->fetchAll();

$pageTitle = 'Program Studi';
$activeNav = 'services';
require __DIR__ . '/includes/header.php';
?>

  <!-- ================= HERO HALAMAN ================= -->
  <section class="relative overflow-hidden paper-texture py-16 sm:py-20">
    <div class="blob-accent w-[360px] h-[360px] -top-24 -right-24"></div>
    <div class="max-w-5xl mx-auto px-5 sm:px-8 text-center relative reveal">
      <span class="badge-ribbon text-pbk-accent text-xs font-bold uppercase tracking-wider justify-center">Program Studi</span>
      <h1 class="font-display font-black text-4xl sm:text-5xl mt-4 mb-5">Pilih Jalur Karier Anda</h1>
      <p class="text-pbk-muted text-lg leading-relaxed max-w-2xl mx-auto">Program studi vokasi terapan yang dirancang bersama mitra industri untuk memastikan Anda siap kerja sejak hari pertama lulus.</p>
    </div>
  </section>

  <!-- ================= NAV JUMP LINKS ================= -->
  <?php if (!empty($produkList)): ?>
  <nav aria-label="Navigasi program studi" class="sticky top-20 z-30 bg-pbk-bg/95 backdrop-blur border-y border-pbk-border">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 py-3 flex gap-3 overflow-x-auto text-sm">
      <?php foreach ($produkList as $p): ?>
        <a href="#produk-<?= (int) $p['id'] ?>" class="flex-shrink-0 px-4 py-2 rounded-full border border-pbk-border hover:bg-pbk-secondary font-medium"><?= h($p['nama']) ?></a>
      <?php endforeach; ?>
    </div>
  </nav>
  <?php endif; ?>

  <?php if (empty($produkList)): ?>
    <div class="max-w-3xl mx-auto px-5 sm:px-8 py-20 text-center text-pbk-muted">Belum ada data program studi/layanan.</div>
  <?php else: $i = 0; foreach ($produkList as $p): $i++; $alt = $i % 2 === 0; $bg = $i % 2 === 0 ? 'bg-pbk-secondary/50' : ''; ?>
  <section id="produk-<?= (int) $p['id'] ?>" class="py-20 <?= $bg ?> scroll-mt-40">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 grid lg:grid-cols-2 gap-12 items-center">
      <div class="reveal rounded-3xl overflow-hidden shadow-xl aspect-[4/3] <?= $alt ? '' : 'order-2 lg:order-1' ?>">
        <img src="<?= BASE_URL ?>/uploads/produk/<?= h($p['gambar']) ?>" onerror="this.src='<?= BASE_URL ?>/images/logo.png'" alt="<?= h($p['nama']) ?>" class="w-full h-full object-cover" loading="lazy" />
      </div>
      <div class="reveal reveal-delay-1 <?= $alt ? '' : 'order-1 lg:order-2' ?>">
        <span class="badge-ribbon text-blue-700 text-xs font-bold uppercase tracking-wider">Jenjang <?= h($p['jenjang']) ?></span>
        <h2 class="font-display font-black text-3xl sm:text-4xl mt-3 mb-4"><?= h($p['nama']) ?></h2>
        <p class="text-pbk-muted leading-relaxed mb-6"><?= h($p['deskripsi']) ?></p>
        <div class="flex gap-8 mb-6">
          <div><div class="font-display font-black text-2xl text-pbk-primary"><?= (int) $p['semester'] ?></div><div class="text-xs text-pbk-muted">Semester</div></div>
          <div><div class="font-display font-black text-2xl text-pbk-primary"><?= (int) $p['sks'] ?></div><div class="text-xs text-pbk-muted">SKS</div></div>
          <div><div class="font-display font-black text-2xl text-pbk-primary"><?= h($p['akreditasi']) ?></div><div class="text-xs text-pbk-muted">Akreditasi</div></div>
        </div>
        <div class="flex flex-wrap gap-3">
          <a href="<?= BASE_URL ?>/produk_detail.php?id=<?= (int) $p['id'] ?>" class="inline-flex items-center gap-2 border border-pbk-primary/25 text-pbk-primary font-semibold px-6 py-3 rounded-full hover:bg-pbk-secondary transition-colors">Lihat Detail</a>
          <a href="<?= BASE_URL ?>/contact.php#pmb" class="inline-flex items-center gap-2 bg-pbk-primary text-white font-semibold px-6 py-3 rounded-full hover:bg-pbk-primarydark transition-colors">Daftar Program Ini</a>
        </div>
      </div>
    </div>
  </section>
  <?php endforeach; endif; ?>

  <!-- ================= CTA ================= -->
  <section class="py-16 bg-pbk-accent/15">
    <div class="max-w-4xl mx-auto px-5 sm:px-8 text-center reveal">
      <h2 class="font-display font-black text-3xl sm:text-4xl mb-4">Masih Bimbang Memilih Prodi?</h2>
      <p class="text-pbk-muted mb-8 max-w-xl mx-auto">Tim admisi kami siap membantu Anda menentukan program studi yang paling sesuai dengan minat dan tujuan karier Anda.</p>
      <a href="<?= BASE_URL ?>/contact.php" class="inline-flex items-center gap-2 bg-pbk-primary text-white font-semibold px-7 py-3.5 rounded-full hover:bg-pbk-primarydark transition-colors">Konsultasi Gratis</a>
    </div>
  </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
