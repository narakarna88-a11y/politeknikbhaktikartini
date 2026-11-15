<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Tentang Kami';
$activeNav = 'about';
require __DIR__ . '/includes/header.php';
?>

  <!-- ================= HERO HALAMAN ================= -->
  <section class="relative overflow-hidden paper-texture py-16 sm:py-20">
    <div class="blob-accent w-[360px] h-[360px] -top-24 -left-24"></div>
    <div class="max-w-5xl mx-auto px-5 sm:px-8 text-center relative reveal">
      <span class="badge-ribbon text-pbk-accent text-xs font-bold uppercase tracking-wider justify-center">Tentang Kami</span>
      <h1 class="font-display font-black text-4xl sm:text-5xl mt-4 mb-5">Sejarah, Visi, dan Nilai Kami</h1>
      <p class="text-pbk-muted text-lg leading-relaxed max-w-2xl mx-auto">Perjalanan Politeknik Bhakti Kartini dalam mencetak tenaga profesional terapan yang siap menjawab kebutuhan industri.</p>
    </div>
  </section>

  <!-- ================= SEJARAH ================= -->
  <section class="py-20">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 grid lg:grid-cols-2 gap-12 items-center">
      <div class="reveal rounded-3xl overflow-hidden shadow-xl aspect-[4/3]">
        <img src="<?= BASE_URL ?>/images/download.jpg" alt="Sejarah kampus Politeknik Bhakti Kartini" class="w-full h-full object-cover" loading="lazy" />
      </div>
      <div class="reveal reveal-delay-1">
        <span class="badge-ribbon text-pbk-primary text-xs font-bold uppercase tracking-wider">Sejak 2020</span>
        <h2 class="font-display font-black text-3xl sm:text-4xl mt-3 mb-5">Perjalanan Kami</h2>
        <p class="text-pbk-muted leading-relaxed mb-4">Pada 30 Januari 2020, Politeknik Bhakti Kartini resmi berdiri berdasarkan Surat Keputusan Mendikbud RI No. 149/M/2020 serta Hasil Akreditasi Politeknik Bhakti Kartini yang resmi ditandatangani oleh Mendikbud RI.</p>
        <p class="text-pbk-muted leading-relaxed">Politeknik Bhakti Kartini berada di bawah naungan Yayasan Amal Bhakti (YAB), yang juga menaungi SMK, Klinik, dan Rumah Sakit Bhakti Kartini.</p>
      </div>
    </div>
  </section>

  <!-- ================= VISI MISI ================= -->
  <section class="py-20 bg-pbk-secondary/60">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
      <div class="grid md:grid-cols-2 gap-8">
        <div class="reveal bg-white rounded-2xl p-8 border border-pbk-border">
          <div class="w-12 h-12 rounded-xl bg-pbk-primary/10 text-pbk-primary flex items-center justify-center mb-5">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <h3 class="font-display font-bold text-2xl mb-3">Visi</h3>
          <p class="text-pbk-muted leading-relaxed">&ldquo;Menjadi Politeknik kebanggaan Bangsa Indonesia dengan mutu terdepan dan berwawasan global pada Tahun 2029.&rdquo;</p>
        </div>
        <div class="reveal reveal-delay-1 bg-white rounded-2xl p-8 border border-pbk-border">
          <div class="w-12 h-12 rounded-xl bg-pbk-accent/15 text-pbk-accent flex items-center justify-center mb-5">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <h3 class="font-display font-bold text-2xl mb-3">Misi</h3>
          <ul class="text-pbk-muted leading-relaxed space-y-2 list-disc list-inside">
            <li>Perbaikan terus menerus dalam bidang pendidikan dan pengajaran.</li>
            <li>Memberikan ruang kondusif untuk melakukan penelitian bagi seluruh civitas akademik.</li>
            <li>Melaksanakan pengabdian nyata kepada masyarakat secara berkesinambungan.</li>
            <li>Melaksanakan pendidikan berkesinambungan bagi Dosen dan Tenaga Kependidikan.</li>
            <li>Menjalin hubungan strategis dan mitra kerja di seluruh dunia.</li>
            <li>Melakukan pembaharuan berkesinambungan di bidang Teknologi Informasi dan Komunikasi.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= NILAI ================= -->
  <section class="py-20">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
      <div class="max-w-2xl mb-12 reveal">
        <span class="badge-ribbon text-pbk-primary text-xs font-bold uppercase tracking-wider">Nilai Kami</span>
        <h2 class="font-display font-black text-3xl sm:text-4xl mt-3">Yang Kami Pegang Teguh</h2>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="reveal text-center p-6">
          <div class="font-display font-black text-5xl text-pbk-primary/15 mb-2">01</div>
          <h3 class="font-bold mb-2">Integritas</h3>
          <p class="text-sm text-pbk-muted leading-relaxed">Menjunjung kejujuran dan tanggung jawab dalam setiap proses pendidikan.</p>
        </div>
        <div class="reveal reveal-delay-1 text-center p-6">
          <div class="font-display font-black text-5xl text-pbk-primary/15 mb-2">02</div>
          <h3 class="font-bold mb-2">Kompetensi</h3>
          <p class="text-sm text-pbk-muted leading-relaxed">Mengutamakan keterampilan praktis yang teruji dan relevan dengan industri.</p>
        </div>
        <div class="reveal reveal-delay-2 text-center p-6">
          <div class="font-display font-black text-5xl text-pbk-primary/15 mb-2">03</div>
          <h3 class="font-bold mb-2">Kolaborasi</h3>
          <p class="text-sm text-pbk-muted leading-relaxed">Membangun kerja sama erat dengan mitra industri dan komunitas.</p>
        </div>
        <div class="reveal reveal-delay-3 text-center p-6">
          <div class="font-display font-black text-5xl text-pbk-primary/15 mb-2">04</div>
          <h3 class="font-bold mb-2">Inovasi</h3>
          <p class="text-sm text-pbk-muted leading-relaxed">Terus beradaptasi dengan perkembangan teknologi dan kebutuhan zaman.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= PIMPINAN ================= -->
  <section class="py-20 bg-pbk-secondary/60">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
      <div class="max-w-2xl mb-12 reveal">
        <span class="badge-ribbon text-pbk-primary text-xs font-bold uppercase tracking-wider">Struktur Pimpinan</span>
        <h2 class="font-display font-black text-3xl sm:text-4xl mt-3">Dipimpin oleh Para Ahli</h2>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="reveal pbk-card bg-white rounded-2xl overflow-hidden border border-pbk-border">
          <img src="<?= BASE_URL ?>/images/direktur.png" alt="Direktur Politeknik Bhakti Kartini" class="w-full h-56 object-cover" loading="lazy" />
          <div class="p-5">
            <h3 class="font-bold">Yusnita Yusfik, SKM., MKM.</h3>
            <p class="text-sm text-pbk-accent font-semibold">Direktur</p>
          </div>
        </div>
        <div class="reveal reveal-delay-1 pbk-card bg-white rounded-2xl overflow-hidden border border-pbk-border">
          <img src="<?= BASE_URL ?>/images/wakildirektur1.png" alt="Wakil Direktur Bidang I" class="w-full h-56 object-cover" loading="lazy" />
          <div class="p-5">
            <h3 class="font-bold">apt. Ayu Fajariyani, S.Farm., M.farm</h3>
            <p class="text-sm text-pbk-accent font-semibold">Wakil Direktur Bidang I</p>
          </div>
        </div>
        <div class="reveal reveal-delay-2 pbk-card bg-white rounded-2xl overflow-hidden border border-pbk-border">
          <img src="<?= BASE_URL ?>/images/wakildirektur2.png" alt="Wakil Direktur Bidang II" class="w-full h-56 object-cover" loading="lazy" />
          <div class="p-5">
            <h3 class="font-bold">Wawan Hermawansyah, S.Kom., M.M.S.I</h3>
            <p class="text-sm text-pbk-accent font-semibold">Wakil Direktur Bidang II</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= AKREDITASI ================= -->
  <section class="py-16">
    <div class="max-w-5xl mx-auto px-5 sm:px-8 text-center reveal">
      <span class="badge-ribbon text-pbk-primary text-xs font-bold uppercase tracking-wider justify-center">Legalitas</span>
      <h2 class="font-display font-black text-3xl mt-3 mb-4">Terakreditasi &amp; Diakui Secara Resmi</h2>
      <p class="text-pbk-muted leading-relaxed max-w-2xl mx-auto">Politeknik Bhakti Kartini berada di bawah naungan Yayasan Bhakti Kartini dan seluruh program studinya telah terakreditasi oleh Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT).</p>
    </div>
  </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
