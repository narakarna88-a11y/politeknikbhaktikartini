<?php
require_once __DIR__ . '/includes/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$isEdit = $id !== null;
$row = ['judul' => '', 'kategori' => 'fasilitas', 'gambar' => null];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        set_flash('error', 'Data gallery tidak ditemukan.');
        redirect('gallery.php');
    }
}

$kategoriList = ['fasilitas' => 'Fasilitas', 'akademik' => 'Akademik', 'kegiatan' => 'Kegiatan', 'wisuda' => 'Wisuda'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Sesi tidak valid, silakan coba lagi.';
    } else {
        $judul = trim($_POST['judul'] ?? '');
        $kategori = $_POST['kategori'] ?? '';

        if ($judul === '') $errors[] = 'Judul wajib diisi.';
        if (!array_key_exists($kategori, $kategoriList)) $errors[] = 'Kategori tidak valid.';

        $upload = upload_gambar($_FILES['gambar'] ?? null, 'gallery', $row['gambar'], !$isEdit);
        if (!$upload['ok']) $errors[] = $upload['msg'];

        if (empty($errors)) {
            if ($isEdit) {
                $stmt = $pdo->prepare("UPDATE gallery SET judul=?, kategori=?, gambar=? WHERE id=?");
                $stmt->execute([$judul, $kategori, $upload['filename'], $id]);
                set_flash('success', 'Foto gallery berhasil diperbarui.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO gallery (judul, kategori, gambar) VALUES (?, ?, ?)");
                $stmt->execute([$judul, $kategori, $upload['filename']]);
                set_flash('success', 'Foto baru berhasil ditambahkan ke gallery.');
            }
            redirect('gallery.php');
        }
        $row = array_merge($row, compact('judul', 'kategori'));
    }
}

$pageTitle = $isEdit ? 'Edit Foto Gallery' : 'Tambah Foto Gallery';
$activeMenu = 'gallery';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="max-w-xl bg-white border border-pbk-border rounded-2xl p-6 sm:p-8">
  <?php if (!empty($errors)): ?>
    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
      <ul class="list-disc list-inside space-y-1"><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul>
    </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" novalidate class="space-y-5">
    <?= csrf_field() ?>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Judul / Keterangan Foto</label>
      <input type="text" name="judul" value="<?= h($row['judul']) ?>" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Kategori</label>
      <select name="kategori" class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30">
        <?php foreach ($kategoriList as $val => $label): ?>
          <option value="<?= h($val) ?>" <?= $row['kategori'] === $val ? 'selected' : '' ?>><?= h($label) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Gambar <?= $isEdit ? '<span class="text-pbk-muted font-normal">(kosongkan jika tidak ingin mengubah)</span>' : '' ?></label>
      <?php if ($isEdit && $row['gambar']): ?>
        <img src="../uploads/gallery/<?= h($row['gambar']) ?>" class="w-24 h-24 object-cover rounded-lg border border-pbk-border mb-2" alt="" />
      <?php endif; ?>
      <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full text-sm" />
      <p class="text-xs text-pbk-muted mt-1">Format JPG/PNG/WEBP, maksimal 2MB.</p>
    </div>
    <div class="flex gap-3 pt-2">
      <button type="submit" class="bg-pbk-primary text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-pbk-primarydark transition-colors">Simpan</button>
      <a href="gallery.php" class="px-6 py-2.5 rounded-xl border border-pbk-border text-sm font-semibold hover:bg-pbk-secondary transition-colors">Batal</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
