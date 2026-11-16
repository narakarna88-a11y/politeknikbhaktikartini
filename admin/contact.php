<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Sesi tidak valid.');
    } else {
        $id = (int) $_POST['id'];
        $pdo->prepare("DELETE FROM pesan_kontak WHERE id = ?")->execute([$id]);
        set_flash('success', 'Pesan berhasil dihapus.');
    }
    redirect('contact.php');
}

$search = trim($_GET['q'] ?? '');
$perPage = 8;
$page = max(1, (int) ($_GET['page'] ?? 1));

$where = '';
$params = [];
if ($search !== '') {
    $where = "WHERE nama LIKE ? OR email LIKE ? OR topik LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%"];
}

$totalRows = $pdo->prepare("SELECT COUNT(*) c FROM pesan_kontak $where");
$totalRows->execute($params);
$totalRows = $totalRows->fetch()['c'];
$pg = paginate_info($totalRows, $perPage, $page);

$stmt = $pdo->prepare("SELECT * FROM pesan_kontak $where ORDER BY created_at DESC LIMIT $perPage OFFSET {$pg['offset']}");
$stmt->execute($params);
$data = $stmt->fetchAll();

$pageTitle = 'Pesan Contact';
$activeMenu = 'contact';
require __DIR__ . '/includes/layout_top.php';
?>

<form method="GET" class="max-w-sm mb-6">
  <div class="relative">
    <input type="text" name="q" value="<?= h($search) ?>" placeholder="Cari nama, email, atau topik..." class="w-full rounded-xl border border-pbk-border pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    <svg class="w-4 h-4 text-pbk-muted absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
  </div>
</form>

<div class="space-y-4">
  <?php if (empty($data)): ?>
    <p class="text-center text-pbk-muted py-8">Tidak ada pesan ditemukan.</p>
  <?php else: foreach ($data as $row): ?>
    <details class="bg-white border border-pbk-border rounded-2xl p-5 group">
      <summary class="cursor-pointer list-none flex items-center justify-between gap-4">
        <div class="min-w-0">
          <div class="flex items-center gap-2 flex-wrap">
            <span class="font-bold"><?= h($row['nama']) ?></span>
            <span class="px-2 py-0.5 rounded-full text-xs font-semibold <?= $row['status'] === 'baru' ? 'bg-pbk-accent/15 text-pbk-accent' : 'bg-gray-100 text-gray-500' ?>"><?= h(ucfirst($row['status'])) ?></span>
          </div>
          <div class="text-xs text-pbk-muted mt-1 truncate"><?= h($row['email']) ?> &middot; <?= h($row['topik']) ?> &middot; <?= h(date('d/m/Y H:i', strtotime($row['created_at']))) ?></div>
        </div>
        <svg class="w-5 h-5 text-pbk-primary flex-shrink-0 transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
      </summary>
      <div class="mt-4 pt-4 border-t border-pbk-border text-sm">
        <p class="text-pbk-muted mb-1">No. HP/WhatsApp: <?= h($row['telepon'] ?: '-') ?></p>
        <p class="leading-relaxed whitespace-pre-line mb-4"><?= h($row['pesan']) ?></p>
        <form method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan dari \'<?= h(addslashes($row['nama'])) ?>\'?');">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="delete" />
          <input type="hidden" name="id" value="<?= (int) $row['id'] ?>" />
          <button type="submit" class="px-4 py-2 rounded-lg border border-red-200 text-red-600 text-xs font-semibold hover:bg-red-50">Hapus Pesan</button>
        </form>
      </div>
    </details>
  <?php endforeach; endif; ?>
</div>

<?= render_pagination($pg['page'], $pg['totalPages'], 'contact.php', ['q' => $search]) ?>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
