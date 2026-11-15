<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$kategoriList = ['fasilitas' => 'Fasilitas', 'akademik' => 'Akademik', 'kegiatan' => 'Kegiatan', 'wisuda' => 'Wisuda'];
$filter = $_GET['kategori'] ?? 'all';
$perPage = 9;
$page = max(1, (int) ($_GET['page'] ?? 1));

$where = '';
$params = [];
if ($filter !== 'all' && array_key_exists($filter, $kategoriList)) {
    $where = "WHERE kategori = ?";
    $params = [$filter];
}

$totalRows = $pdo->prepare("SELECT COUNT(*) c FROM gallery $where");
$totalRows->execute($params);
$totalRows = $totalRows->fetch()['c'];
$pg = paginate_info($totalRows, $perPage, $page);

$stmt = $pdo->prepare("SELECT * FROM gallery $where ORDER BY id DESC LIMIT $perPage OFFSET {$pg['offset']}");
$stmt->execute($params);
$fotoList = $stmt->fetchAll();

$pageTitle = 'Galeri';
$activeNav = 'gallery';
require __DIR__ . '/includes/header.php';
?>

  <!-- ================= HERO HALAMAN ================= -->
  <section class="relative overflow-hidden paper-texture py-16 sm:py-20">
    <div class="blob-accent w-[360px] h-[360px] -top-24 -left-24"></div>
    <div class="max-w-5xl mx-auto px-5 sm:px-8 text-center relative reveal">
      <span class="badge-ribbon text-pbk-accent text-xs font-bold uppercase tracking-wider justify-center">Galeri</span>
      <h1 class="font-display font-black text-4xl sm:text-5xl mt-4 mb-5">Momen &amp; Kegiatan Kampus</h1>
      <p class="text-pbk-muted text-lg leading-relaxed max-w-2xl mx-auto">Dokumentasi fasilitas, kegiatan akademik, dan keseharian mahasiswa Politeknik Bhakti Kartini.</p>
    </div>
  </section>

  <!-- ================= FILTER (kategori dari database) ================= -->
  <section class="pb-4">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 flex flex-wrap gap-3">
      <a href="?kategori=all" class="text-sm font-semibold px-5 py-2.5 rounded-full border <?= $filter === 'all' ? 'bg-pbk-primary text-white border-pbk-primary' : 'border-pbk-border hover:bg-pbk-secondary' ?>">Semua</a>
      <?php foreach ($kategoriList as $key => $label): ?>
        <a href="?kategori=<?= h($key) ?>" class="text-sm font-semibold px-5 py-2.5 rounded-full border <?= $filter === $key ? 'bg-pbk-primary text-white border-pbk-primary' : 'border-pbk-border hover:bg-pbk-secondary' ?>"><?= h($label) ?></a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ================= GRID GALERI (DINAMIS) ================= -->
  <section class="py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
      <?php if (empty($fotoList)): ?>
        <p class="text-center text-pbk-muted py-12">Belum ada foto pada kategori ini.</p>
      <?php else: ?>
        <div class="columns-1 sm:columns-2 lg:columns-3 gap-5 space-y-5">
          <?php foreach ($fotoList as $foto): ?>
            <div class="gallery-item reveal rounded-2xl overflow-hidden border border-pbk-border break-inside-avoid cursor-pointer" data-full="<?= BASE_URL ?>/uploads/gallery/<?= h($foto['gambar']) ?>" data-caption="<?= h($foto['judul']) ?>">
              <img src="<?= BASE_URL ?>/uploads/gallery/<?= h($foto['gambar']) ?>" onerror="this.src='<?= BASE_URL ?>/images/logo.png'" alt="<?= h($foto['judul']) ?>" class="w-full h-auto" loading="lazy" />
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?= render_pagination($pg['page'], $pg['totalPages'], 'gallery.php', ['kategori' => $filter]) ?>
    </div>
  </section>

<!-- ================= LIGHTBOX ================= -->
<div id="lightbox" class="lightbox-overlay" role="dialog" aria-modal="true" aria-label="Pratinjau gambar">
  <button id="lightboxClose" aria-label="Tutup pratinjau" class="absolute top-5 right-5 text-white/80 hover:text-white">
    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
  </button>
  <figure class="max-w-3xl w-full">
    <img id="lightboxImg" src="" alt="" class="w-full max-h-[75vh] object-contain rounded-xl" />
    <figcaption id="lightboxCaption" class="text-white/80 text-sm text-center mt-4"></figcaption>
  </figure>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
