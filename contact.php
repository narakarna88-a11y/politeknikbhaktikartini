<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$success = false;
$old = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $errors['general'] = 'Sesi tidak valid, silakan muat ulang halaman dan coba lagi.';
    } else {
        $old['name'] = trim($_POST['name'] ?? '');
        $old['email'] = trim($_POST['email'] ?? '');
        $old['phone'] = trim($_POST['phone'] ?? '');
        $old['subject'] = trim($_POST['subject'] ?? '');
        $old['message'] = trim($_POST['message'] ?? '');

        if ($old['name'] === '') {
            $errors['name'] = 'Nama wajib diisi.';
        }
        if ($old['email'] === '') {
            $errors['email'] = 'Email wajib diisi.';
        } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid.';
        }
        if ($old['subject'] === '') {
            $errors['subject'] = 'Silakan pilih topik.';
        }
        if ($old['message'] === '') {
            $errors['message'] = 'Pesan wajib diisi.';
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO pesan_kontak (nama, email, telepon, topik, pesan) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$old['name'], $old['email'], $old['phone'], $old['subject'], $old['message']]);
            $success = true;
            $old = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];
        }
    }
}

$pageTitle = 'Kontak';
$activeNav = 'contact';
require __DIR__ . '/includes/header.php';
?>

  <!-- ================= HERO HALAMAN ================= -->
  <section class="relative overflow-hidden paper-texture py-16 sm:py-20">
    <div class="blob-accent w-[360px] h-[360px] -top-24 -right-24"></div>
    <div class="max-w-5xl mx-auto px-5 sm:px-8 text-center relative reveal">
      <span class="badge-ribbon text-pbk-accent text-xs font-bold uppercase tracking-wider justify-center">Kontak Kami</span>
      <h1 class="font-display font-black text-4xl sm:text-5xl mt-4 mb-5">Mari Terhubung</h1>
      <p class="text-pbk-muted text-lg leading-relaxed max-w-2xl mx-auto">Punya pertanyaan tentang pendaftaran atau program studi? Tim kami siap membantu Anda.</p>
    </div>
  </section>

  <!-- ================= INFO KONTAK CEPAT ================= -->
  <section class="pb-4">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 grid sm:grid-cols-3 gap-6">
      <div class="reveal bg-white border border-pbk-border rounded-2xl p-6 flex flex-col gap-3">
        <div class="w-11 h-11 rounded-xl bg-pbk-secondary text-pbk-primary flex items-center justify-center">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
        </div>
        <h3 class="font-bold">Telepon</h3>
        <p class="text-sm text-pbk-muted">(021) 8930-1234<br />(021) 8930-1235</p>
        <p class="text-xs text-pbk-muted">Senin–Jumat, 08.00–16.00 WIB</p>
      </div>
      <div class="reveal reveal-delay-1 bg-white border border-pbk-border rounded-2xl p-6 flex flex-col gap-3">
        <div class="w-11 h-11 rounded-xl bg-pbk-secondary text-pbk-primary flex items-center justify-center">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
        </div>
        <h3 class="font-bold">Email</h3>
        <p class="text-sm text-pbk-muted">info@pbk.ac.id<br />pmb@pbk.ac.id</p>
        <p class="text-xs text-pbk-muted">Balasan dalam 1×24 jam kerja</p>
      </div>
      <div class="reveal reveal-delay-2 bg-white border border-pbk-border rounded-2xl p-6 flex flex-col gap-3">
        <div class="w-11 h-11 rounded-xl bg-pbk-secondary text-pbk-primary flex items-center justify-center">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
        </div>
        <h3 class="font-bold">Alamat</h3>
        <p class="text-sm text-pbk-muted">Jl. Bhakti Kartini No. 1,<br />Bekasi, Jawa Barat 17144</p>
        <p class="text-xs text-pbk-muted">Jawa Barat, Indonesia</p>
      </div>
    </div>
  </section>

  <!-- ================= FORM + MAP ================= -->
  <section id="pmb" class="py-16 sm:py-20 scroll-mt-24">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 grid lg:grid-cols-5 gap-10">

      <!-- FORM (VALIDASI SERVER-SIDE PHP) -->
      <div class="lg:col-span-3 reveal bg-white border border-pbk-border rounded-3xl p-6 sm:p-8">
        <h2 class="font-display font-black text-2xl sm:text-3xl mb-2">Kirim Pesan atau Pertanyaan</h2>
        <p class="text-pbk-muted text-sm mb-6">Isi formulir di bawah ini, tim admisi kami akan menghubungi Anda kembali.</p>

        <?php if ($success): ?>
          <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3">
            Pesan Anda berhasil terkirim. Tim kami akan segera menghubungi Anda.
          </div>
        <?php endif; ?>

        <?php if (!empty($errors['general'])): ?>
          <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3"><?= h($errors['general']) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
          <?= csrf_field() ?>
          <div class="grid sm:grid-cols-2 gap-5 mb-5">
            <div>
              <label for="name" class="block text-sm font-semibold mb-1.5">Nama Lengkap</label>
              <input type="text" id="name" name="name" value="<?= h($old['name']) ?>" class="pbk-field w-full rounded-xl px-4 py-3 text-sm <?= isset($errors['name']) ? 'border-red-400' : '' ?>" placeholder="Nama Anda" />
              <p class="field-error-msg <?= isset($errors['name']) ? 'show' : '' ?>"><?= isset($errors['name']) ? h($errors['name']) : '' ?></p>
            </div>
            <div>
              <label for="email" class="block text-sm font-semibold mb-1.5">Email</label>
              <input type="email" id="email" name="email" value="<?= h($old['email']) ?>" class="pbk-field w-full rounded-xl px-4 py-3 text-sm <?= isset($errors['email']) ? 'border-red-400' : '' ?>" placeholder="nama@email.com" />
              <p class="field-error-msg <?= isset($errors['email']) ? 'show' : '' ?>"><?= isset($errors['email']) ? h($errors['email']) : '' ?></p>
            </div>
          </div>

          <div class="grid sm:grid-cols-2 gap-5 mb-5">
            <div>
              <label for="phone" class="block text-sm font-semibold mb-1.5">No. HP / WhatsApp <span class="text-pbk-muted font-normal">(opsional)</span></label>
              <input type="tel" id="phone" name="phone" value="<?= h($old['phone']) ?>" class="pbk-field w-full rounded-xl px-4 py-3 text-sm" placeholder="08xx-xxxx-xxxx" />
            </div>
            <div>
              <label for="subject" class="block text-sm font-semibold mb-1.5">Topik</label>
              <select id="subject" name="subject" class="pbk-field w-full rounded-xl px-4 py-3 text-sm <?= isset($errors['subject']) ? 'border-red-400' : '' ?>">
                <option value="" <?= $old['subject'] === '' ? 'selected' : '' ?>>Pilih topik</option>
                <option value="pmb" <?= $old['subject'] === 'pmb' ? 'selected' : '' ?>>Pendaftaran Mahasiswa Baru</option>
                <option value="prodi" <?= $old['subject'] === 'prodi' ? 'selected' : '' ?>>Informasi Program Studi</option>
                <option value="beasiswa" <?= $old['subject'] === 'beasiswa' ? 'selected' : '' ?>>Beasiswa</option>
                <option value="kerjasama" <?= $old['subject'] === 'kerjasama' ? 'selected' : '' ?>>Kerja Sama Industri</option>
                <option value="lainnya" <?= $old['subject'] === 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
              </select>
              <p class="field-error-msg <?= isset($errors['subject']) ? 'show' : '' ?>"><?= isset($errors['subject']) ? h($errors['subject']) : '' ?></p>
            </div>
          </div>

          <div class="mb-6">
            <label for="message" class="block text-sm font-semibold mb-1.5">Pesan</label>
            <textarea id="message" name="message" rows="5" class="pbk-field w-full rounded-xl px-4 py-3 text-sm resize-none <?= isset($errors['message']) ? 'border-red-400' : '' ?>" placeholder="Tuliskan pertanyaan atau pesan Anda..."><?= h($old['message']) ?></textarea>
            <p class="field-error-msg <?= isset($errors['message']) ? 'show' : '' ?>"><?= isset($errors['message']) ? h($errors['message']) : '' ?></p>
          </div>

          <button type="submit" class="inline-flex items-center gap-2 bg-pbk-primary text-white font-semibold px-7 py-3.5 rounded-full hover:bg-pbk-primarydark transition-colors">
            Kirim Pesan
          </button>
        </form>
      </div>

      <!-- MAP + JAM OPERASIONAL -->
      <div class="lg:col-span-2 reveal reveal-delay-1 flex flex-col gap-6">
        <div class="rounded-3xl overflow-hidden border border-pbk-border shadow-sm aspect-[4/3]">
          <iframe
            title="Lokasi Politeknik Bhakti Kartini di Google Maps"
            src="https://www.google.com/maps?q=Bekasi,Jawa+Barat&output=embed"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
        <div class="bg-pbk-primary text-white rounded-3xl p-6 sm:p-8">
          <h3 class="font-display font-bold text-xl mb-4">Jam Operasional</h3>
          <ul class="space-y-2 text-sm text-white/85">
            <li class="flex justify-between"><span>Senin – Jumat</span><span>08.00 – 16.00 WIB</span></li>
            <li class="flex justify-between"><span>Sabtu</span><span>08.00 – 12.00 WIB</span></li>
            <li class="flex justify-between"><span>Minggu &amp; Libur Nasional</span><span>Tutup</span></li>
          </ul>
          <div class="mt-6 pt-6 border-t border-white/15">
            <p class="text-sm text-white/85 mb-3">Ikuti kami di media sosial:</p>
            <div class="flex gap-3">
              <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">IG</a>
              <a href="#" aria-label="YouTube" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">YT</a>
              <a href="#" aria-label="LinkedIn" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">IN</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= FAQ ================= -->
  <section class="py-16 sm:py-20 bg-pbk-secondary/50">
    <div class="max-w-4xl mx-auto px-5 sm:px-8">
      <div class="text-center mb-10 reveal">
        <span class="badge-ribbon text-pbk-primary text-xs font-bold uppercase tracking-wider justify-center">FAQ</span>
        <h2 class="font-display font-black text-3xl sm:text-4xl mt-3">Pertanyaan Umum</h2>
      </div>
      <div class="space-y-4">
        <details class="reveal bg-white border border-pbk-border rounded-2xl p-5 group">
          <summary class="font-semibold cursor-pointer list-none flex items-center justify-between">
            Kapan pendaftaran mahasiswa baru dibuka?
            <svg class="w-5 h-5 text-pbk-primary transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          </summary>
          <p class="text-sm text-pbk-muted mt-3 leading-relaxed">Pendaftaran gelombang pertama tahun ajaran 2026/2027 telah dibuka dan berlangsung hingga 31 Agustus 2026. Pendaftaran dilakukan secara online melalui portal kampus.</p>
        </details>
        <details class="reveal reveal-delay-1 bg-white border border-pbk-border rounded-2xl p-5 group">
          <summary class="font-semibold cursor-pointer list-none flex items-center justify-between">
            Apakah tersedia beasiswa?
            <svg class="w-5 h-5 text-pbk-primary transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          </summary>
          <p class="text-sm text-pbk-muted mt-3 leading-relaxed">Ya. Kami menyediakan beasiswa prestasi akademik dan non-akademik bagi calon mahasiswa maupun mahasiswa aktif yang memenuhi kriteria.</p>
        </details>
        <details class="reveal reveal-delay-2 bg-white border border-pbk-border rounded-2xl p-5 group">
          <summary class="font-semibold cursor-pointer list-none flex items-center justify-between">
            Apakah semua program studi sudah terakreditasi?
            <svg class="w-5 h-5 text-pbk-primary transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          </summary>
          <p class="text-sm text-pbk-muted mt-3 leading-relaxed">Ya, seluruh program studi di Politeknik Bhakti Kartini telah terakreditasi resmi oleh BAN-PT.</p>
        </details>
        <details class="reveal reveal-delay-3 bg-white border border-pbk-border rounded-2xl p-5 group">
          <summary class="font-semibold cursor-pointer list-none flex items-center justify-between">
            Bagaimana cara mengunjungi kampus secara langsung?
            <svg class="w-5 h-5 text-pbk-primary transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          </summary>
          <p class="text-sm text-pbk-muted mt-3 leading-relaxed">Anda dapat mengunjungi kampus kami di Jl. Bhakti Kartini No. 1, Bekasi pada jam operasional, atau menghubungi kami terlebih dahulu untuk membuat janji kunjungan.</p>
        </details>
      </div>
    </div>
  </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
