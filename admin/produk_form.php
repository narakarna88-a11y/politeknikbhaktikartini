<?php
require_once __DIR__ . '/includes/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$isEdit = $id !== null;
$row = ['nama' => '', 'jenjang' => '', 'deskripsi' => '', 'detail' => '', 'gambar' => null, 'semester' => '', 'sks' => '', 'akreditasi' => ''];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        set_flash('error', 'Data produk/layanan tidak ditemukan.');
        redirect('produk.php');
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Sesi tidak valid, silakan coba lagi.';
    } else {
        $nama = trim($_POST['nama'] ?? '');
        $jenjang = trim($_POST['jenjang'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $detail = trim($_POST['detail'] ?? '');
        $semester = (int) ($_POST['semester'] ?? 0);
        $sks = (int) ($_POST['sks'] ?? 0);
        $akreditasi = trim($_POST['akreditasi'] ?? '');

        if ($nama === '') $errors[] = 'Nama wajib diisi.';
        if ($jenjang === '') $errors[] = 'Jenjang wajib diisi.';
        if ($deskripsi === '') $errors[] = 'Deskripsi wajib diisi.';
        if ($semester <= 0) $errors[] = 'Jumlah semester harus lebih dari 0.';
        if ($sks <= 0) $errors[] = 'Jumlah SKS harus lebih dari 0.';

        $upload = upload_gambar($_FILES['gambar'] ?? null, 'produk', $row['gambar'], !$isEdit);
        if (!$upload['ok']) $errors[] = $upload['msg'];

        if (empty($errors)) {
            if ($isEdit) {
                $stmt = $pdo->prepare("UPDATE produk SET nama=?, jenjang=?, deskripsi=?, detail=?, gambar=?, semester=?, sks=?, akreditasi=? WHERE id=?");
                $stmt->execute([$nama, $jenjang, $deskripsi, $detail, $upload['filename'], $semester, $sks, $akreditasi, $id]);
                set_flash('success', 'Data produk/layanan berhasil diperbarui.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO produk (nama, jenjang, deskripsi, detail, gambar, semester, sks, akreditasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nama, $jenjang, $deskripsi, $detail, $upload['filename'], $semester, $sks, $akreditasi]);
                set_flash('success', 'Produk/layanan baru berhasil ditambahkan.');
            }
            redirect('produk.php');
        }
        $row = array_merge($row, compact('nama', 'jenjang', 'deskripsi', 'detail', 'semester', 'sks', 'akreditasi'));
    }
}

$pageTitle = $isEdit ? 'Edit Produk/Layanan' : 'Tambah Produk/Layanan';
$activeMenu = 'produk';
require __DIR__ . '/includes/layout_top.php';
?>

<div class="max-w-2xl bg-white border border-pbk-border rounded-2xl p-6 sm:p-8">
  <?php if (!empty($errors)): ?>
    <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
      <ul class="list-disc list-inside space-y-1"><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul>
    </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" novalidate class="space-y-5">
    <?= csrf_field() ?>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Nama Program / Layanan</label>
      <input type="text" name="nama" value="<?= h($row['nama']) ?>" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Jenjang</label>
      <input type="text" name="jenjang" value="<?= h($row['jenjang']) ?>" placeholder="Contoh: D3 - Ahli Madya" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Deskripsi Singkat</label>
      <textarea name="deskripsi" rows="3" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30"><?= h($row['deskripsi']) ?></textarea>
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Detail Kompetensi</label>
      <textarea name="detail" rows="4" class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30"><?= h($row['detail']) ?></textarea>
    </div>
    <div class="grid sm:grid-cols-3 gap-5">
      <div>
        <label class="block text-sm font-semibold mb-1.5">Semester</label>
        <input type="number" name="semester" value="<?= h($row['semester']) ?>" min="1" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1.5">SKS</label>
        <input type="number" name="sks" value="<?= h($row['sks']) ?>" min="1" required class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1.5">Akreditasi</label>
        <input type="text" name="akreditasi" value="<?= h($row['akreditasi']) ?>" maxlength="5" placeholder="A / B / C" class="w-full rounded-xl border border-pbk-border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pbk-primary/30" />
      </div>
    </div>
    <div>
      <label class="block text-sm font-semibold mb-1.5">Gambar <?= $isEdit ? '<span class="text-pbk-muted font-normal">(kosongkan jika tidak ingin mengubah)</span>' : '' ?></label>
      <?php if ($isEdit && $row['gambar']): ?>
        <img src="../uploads/produk/<?= h($row['gambar']) ?>" class="w-24 h-24 object-cover rounded-lg border border-pbk-border mb-2" alt="" />
      <?php endif; ?>
      <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full text-sm" />
      <p class="text-xs text-pbk-muted mt-1">Format JPG/PNG/WEBP, maksimal 2MB.</p>
    </div>
    <div class="flex gap-3 pt-2">
      <button type="submit" class="bg-pbk-primary text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-pbk-primarydark transition-colors">Simpan</button>
      <a href="produk.php" class="px-6 py-2.5 rounded-xl border border-pbk-border text-sm font-semibold hover:bg-pbk-secondary transition-colors">Batal</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
