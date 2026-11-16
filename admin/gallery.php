<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Sesi tidak valid.');
    } else {
        $id = (int) $_POST['id'];
        $stmt = $pdo->prepare("SELECT gambar FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $old = $stmt->fetch();
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        if ($old && $old['gambar'] && file_exists(__DIR__ . '/../uploads/gallery/' . $old['gambar'])) {
            @unlink(__DIR__ . '/../uploads/gallery/' . $old['gambar']);
        }
        set_flash('success', 'Foto gallery berhasil dihapus.');
    }
    redirect('gallery.php');
}

$search = trim($_GET['q'] ?? '');
$perPage = 8;
$page = max(1, (int) ($_GET['page'] ?? 1));

$where = '';
$params = [];
if ($search !== '') {
    $where = "WHERE judul LIKE ? OR kategori LIKE ?";
    $params = ["%$search%", "%$search%"];
}

$totalRows = $pdo->prepare("SELECT COUNT(*) c FROM gallery $where");
$totalRows->execute($params);
$totalRows = $totalRows->fetch()['c'];
$pg = paginate_info($totalRows, $perPage, $page);

$stmt = $pdo->prepare("SELECT * FROM gallery $where ORDER BY id DESC LIMIT $perPage OFFSET {$pg['offset']}");
$stmt->execute($params);
$data = $stmt->fetchAll();

$pageTitle = 'Gallery';
$activeMenu = 'gallery';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
  <form method="GET" class="flex-1 max-w-sm">
    <div class="relative">
      <input type="text" name="q" value="<?= h($search) ?>" placeholder="Cari judul atau kategori..." class="w-full rounded-xl border border-pbk-border pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      <svg class="w-4 h-4 text-pbk-muted absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
    </div>
  </form>
  <a href="gallery_form.php" class="inline-flex items-center gap-2 bg-pbk-primary text-white font-semibold px-5 py-2.5 rounded-xl text-sm hover:bg-pbk-primarydark transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
    Tambah Foto
  </a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
  <?php if (empty($data)): ?>
    <p class="col-span-full text-center text-pbk-muted py-8">Tidak ada data ditemukan.</p>
  <?php else: foreach ($data as $row): ?>
    <div class="bg-white border border-pbk-border rounded-2xl overflow-hidden">
      <img src="../uploads/gallery/<?= h($row['gambar']) ?>" onerror="this.src='../images/logo.png'" class="w-full h-36 object-cover" alt="" />
      <div class="p-4">
        <div class="text-xs font-semibold text-pbk-accent uppercase mb-1"><?= h($row['kategori']) ?></div>
        <div class="font-medium text-sm mb-3 line-clamp-2"><?= h($row['judul']) ?></div>
        <div class="flex gap-2">
          <a href="gallery_form.php?id=<?= (int) $row['id'] ?>" class="flex-1 text-center px-3 py-1.5 rounded-lg border border-pbk-border text-xs font-semibold hover:bg-pbk-secondary">Edit</a>
          <form method="POST" onsubmit="return confirm('Yakin ingin menghapus foto \'<?= h(addslashes($row['judul'])) ?>\'?');" class="flex-1">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="delete" />
            <input type="hidden" name="id" value="<?= (int) $row['id'] ?>" />
            <button type="submit" class="w-full px-3 py-1.5 rounded-lg border border-red-200 text-red-600 text-xs font-semibold hover:bg-red-50">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; endif; ?>
</div>

<?= render_pagination($pg['page'], $pg['totalPages'], 'gallery.php', ['q' => $search]) ?>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
