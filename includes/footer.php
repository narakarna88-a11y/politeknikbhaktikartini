</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-pbk-primary text-white pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-5 sm:px-8 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
    <div>
      <div class="flex items-center gap-3 mb-4">
        <img src="<?= BASE_URL ?>/images/logo.png" alt="Logo Politeknik Bhakti Kartini" class="w-11 h-11 object-contain rounded-full flex-shrink-0" />
        <div class="font-display font-bold">Politeknik Bhakti Kartini</div>
      </div>
      <p class="text-sm text-white/70 leading-relaxed">Kampus vokasi terapan dengan kurikulum berbasis industri dan lulusan siap kerja.</p>
    </div>
    <div>
      <h4 class="font-bold mb-4 text-sm uppercase tracking-wide">Program Studi</h4>
      <ul class="space-y-2 text-sm text-white/70">
        <?php
        $footerProduk = $pdo->query("SELECT id, nama FROM produk ORDER BY id ASC LIMIT 4")->fetchAll();
        foreach ($footerProduk as $fp):
        ?>
          <li><a href="<?= BASE_URL ?>/produk_detail.php?id=<?= (int) $fp['id'] ?>" class="hover:text-white"><?= h($fp['nama']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <h4 class="font-bold mb-4 text-sm uppercase tracking-wide">Tautan</h4>
      <ul class="space-y-2 text-sm text-white/70">
        <li><a href="<?= BASE_URL ?>/about.php" class="hover:text-white">Tentang Kami</a></li>
        <li><a href="<?= BASE_URL ?>/gallery.php" class="hover:text-white">Galeri</a></li>
        <li><a href="<?= BASE_URL ?>/contact.php" class="hover:text-white">Kontak</a></li>
        <li><a href="<?= BASE_URL ?>/contact.php#pmb" class="hover:text-white">Pendaftaran</a></li>
      </ul>
    </div>
    <div>
      <h4 class="font-bold mb-4 text-sm uppercase tracking-wide">Kontak</h4>
      <ul class="space-y-2 text-sm text-white/70">
        <li>Jl. Caringin Jembatan 14, RT.001/RW.005, Bojong Rawalumbu, Kec. Rawalumbu, Kota Bekasi, Jawa Barat 17116</li>
        <li>(021) 8930-1234</li>
        <li>info@pbk.ac.id</li>
      </ul>
    </div>
  </div>
  <div class="max-w-7xl mx-auto px-5 sm:px-8 mt-12 pt-6 border-t border-white/15 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/60">
    <p>&copy; <span class="current-year">2026</span> Politeknik Bhakti Kartini. Seluruh hak cipta dilindungi.</p>
    <div class="flex gap-4">
      <a href="#" aria-label="Instagram" class="hover:text-white">Instagram</a>
      <a href="#" aria-label="YouTube" class="hover:text-white">YouTube</a>
      <a href="#" aria-label="LinkedIn" class="hover:text-white">LinkedIn</a>
    </div>
  </div>
</footer>

<button id="backToTop" aria-label="Kembali ke atas" class="fixed bottom-6 right-6 z-40 bg-pbk-primary text-white w-11 h-11 rounded-full shadow-lg flex items-center justify-center hover:bg-pbk-primarydark">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
</button>

<script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
</html>
