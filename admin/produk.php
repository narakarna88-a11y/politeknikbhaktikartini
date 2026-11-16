<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Sesi tidak valid.');
    } else {
        $id = (int) $_POST['id'];
        $stmt = $pdo->prepare("SELECT gambar FROM produk WHERE id = ?");
        $stmt->execute([$id]);
        $old = $stmt->fetch();
        $pdo->prepare("DELETE FROM produk WHERE id = ?")->execute([$id]);
        if ($old && $old['gambar'] && file_exists(__DIR__ . '/../uploads/produk/' . $old['gambar'])) {
            @unlink(__DIR__ . '/../uploads/produk/' . $old['gambar']);
        }
        set_flash('success', 'Data produk/layanan berhasil dihapus.');
    }
    redirect('produk.php');
}

$search = trim($_GET['q'] ?? '');
$perPage = 6;
$page = max(1, (int) ($_GET['page'] ?? 1));

$where = '';
$params = [];
if ($search !== '') {
    $where = "WHERE nama LIKE ? OR jenjang LIKE ?";
    $params = ["%$search%", "%$search%"];
}

$totalRows = $pdo->prepare("SELECT COUNT(*) c FROM produk $where");
$totalRows->execute($params);
$totalRows = $totalRows->fetch()['c'];
$pg = paginate_info($totalRows, $perPage, $page);

$stmt = $pdo->prepare("SELECT * FROM produk $where ORDER BY id DESC LIMIT $perPage OFFSET {$pg['offset']}");
$stmt->execute($params);
$data = $stmt->fetchAll();

$pageTitle = 'Produk / Layanan';
$activeMenu = 'produk';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
  <form method="GET" class="flex-1 max-w-sm">
    <div class="relative">
      <input type="text" name="q" value="<?= h($search) ?>" placeholder="Cari nama atau jenjang..." class="w-full rounded-xl border border-pbk-border pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      <svg class="w-4 h-4 text-pbk-muted absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
    </div>
  </form>
  <a href="produk_form.php" class="inline-flex items-center gap-2 bg-pbk-primary text-white font-semibold px-5 py-2.5 rounded-xl text-sm hover:bg-pbk-primarydark transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
    Tambah Produk/Layanan
  </a>
</div>

<div class="bg-white border border-pbk-border rounded-2xl overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-pbk-secondary/50">
        <tr class="text-left">
          <th class="py-3 px-5">Gambar</th>
          <th class="py-3 px-5">Nama</th>
          <th class="py-3 px-5">Jenjang</th>
          <th class="py-3 px-5">Akreditasi</th>
          <th class="py-3 px-5 text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($data)): ?>
          <tr><td colspan="5" class="py-8 text-center text-pbk-muted">Tidak ada data ditemukan.</td></tr>
        <?php else: foreach ($data as $row): ?>
          <tr class="border-t border-pbk-border">
            <td class="py-3 px-5">
              <img src="../uploads/produk/<?= h($row['gambar']) ?>" onerror="this.src='../images/logo.png'" class="w-14 h-14 object-cover rounded-lg border border-pbk-border" alt="" />
            </td>
            <td class="py-3 px-5 font-medium"><?= h($row['nama']) ?></td>
            <td class="py-3 px-5 text-pbk-muted"><?= h($row['jenjang']) ?></td>
            <td class="py-3 px-5 text-pbk-muted"><?= h($row['akreditasi']) ?></td>
            <td class="py-3 px-5">
              <div class="flex justify-end gap-2">
                <a href="../produk_detail.php?id=<?= (int) $row['id'] ?>" target="_blank" class="px-3 py-1.5 rounded-lg border border-pbk-border text-xs font-semibold hover:bg-pbk-secondary">Lihat</a>
                <a href="produk_form.php?id=<?= (int) $row['id'] ?>" class="px-3 py-1.5 rounded-lg border border-pbk-border text-xs font-semibold hover:bg-pbk-secondary">Edit</a>
                <form method="POST" onsubmit="return confirm('Yakin ingin menghapus \'<?= h(addslashes($row['nama'])) ?>\'?');" class="inline">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="delete" />
                  <input type="hidden" name="id" value="<?= (int) $row['id'] ?>" />
                  <button type="submit" class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 text-xs font-semibold hover:bg-red-50">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= render_pagination($pg['page'], $pg['totalPages'], 'produk.php', ['q' => $search]) ?>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
