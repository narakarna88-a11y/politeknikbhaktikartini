<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= isset($pageTitle) ? h($pageTitle) . ' — ' : '' ?>Politeknik Bhakti Kartini</title>
<meta name="description" content="<?= isset($pageDescription) ? h($pageDescription) : 'Politeknik Bhakti Kartini — kampus vokasi dengan program studi terapan, kurikulum berbasis industri, dan lulusan siap kerja.' ?>" />

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          pbk: {
            bg: "#f8f7f2",
            fg: "#0f1b2d",
            primary: "#0e3a6e",
            primarydark: "#082548",
            secondary: "#e8f0fb",
            accent: "#f5a623",
            muted: "#6b7280",
            border: "#e5e0d5",
          },
        },
        fontFamily: {
          display: ["Lora", "serif"],
          sans: ["Plus Jakarta Sans", "sans-serif"],
        },
      },
    },
  };
</script>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css" />
<link rel="icon" href="<?= BASE_URL ?>/images/logo.png" type="image/jpeg" />
</head>
<body class="bg-pbk-bg text-pbk-fg font-sans antialiased">

<a href="#main" class="skip-link">Langsung ke konten utama</a>

<!-- ================= NAVBAR ================= -->
<header id="siteNav" class="sticky top-0 z-50 bg-pbk-bg/95 backdrop-blur transition-shadow">
  <nav class="max-w-7xl mx-auto px-5 sm:px-8 h-20 flex items-center justify-between">
    <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-3">
      <img src="<?= BASE_URL ?>/images/logo.png" alt="Logo Politeknik Bhakti Kartini" class="w-11 h-11 object-contain rounded-full flex-shrink-0" />
      <div class="leading-tight">
        <div class="font-display font-bold text-pbk-primary text-base">Politeknik Bhakti Kartini</div>
        <div class="text-xs text-pbk-muted">Kampus Vokasi Terapan</div>
      </div>
    </a>

    <div class="hidden md:flex items-center gap-8">
      <a href="<?= BASE_URL ?>/index.php" class="nav-link <?= ($activeNav ?? '') === 'home' ? 'active' : '' ?> text-sm pb-1">Beranda</a>
      <a href="<?= BASE_URL ?>/about.php" class="nav-link <?= ($activeNav ?? '') === 'about' ? 'active' : '' ?> text-sm pb-1">Tentang</a>
      <a href="<?= BASE_URL ?>/services.php" class="nav-link <?= ($activeNav ?? '') === 'services' ? 'active' : '' ?> text-sm pb-1">Program Studi</a>
      <a href="<?= BASE_URL ?>/gallery.php" class="nav-link <?= ($activeNav ?? '') === 'gallery' ? 'active' : '' ?> text-sm pb-1">Galeri</a>
      <a href="<?= BASE_URL ?>/contact.php" class="nav-link <?= ($activeNav ?? '') === 'contact' ? 'active' : '' ?> text-sm pb-1">Kontak</a>
    </div>

    <a href="<?= BASE_URL ?>/contact.php#pmb" class="hidden md:inline-flex items-center bg-pbk-primary text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-pbk-primarydark transition-colors">
      Daftar Sekarang
    </a>

    <button id="menuToggle" aria-label="Buka menu" aria-expanded="false" class="md:hidden p-2 -mr-2 text-pbk-primary">
      <svg class="icon-open w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      <svg class="icon-close w-7 h-7 hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
  </nav>

  <div id="mobileMenu" class="md:hidden border-t border-pbk-primary/10">
    <div class="px-5 py-4 flex flex-col gap-4">
      <a href="<?= BASE_URL ?>/index.php" class="text-sm font-medium <?= ($activeNav ?? '') === 'home' ? 'text-pbk-primary' : '' ?>">Beranda</a>
      <a href="<?= BASE_URL ?>/about.php" class="text-sm font-medium <?= ($activeNav ?? '') === 'about' ? 'text-pbk-primary' : '' ?>">Tentang</a>
      <a href="<?= BASE_URL ?>/services.php" class="text-sm font-medium <?= ($activeNav ?? '') === 'services' ? 'text-pbk-primary' : '' ?>">Program Studi</a>
      <a href="<?= BASE_URL ?>/gallery.php" class="text-sm font-medium <?= ($activeNav ?? '') === 'gallery' ? 'text-pbk-primary' : '' ?>">Galeri</a>
      <a href="<?= BASE_URL ?>/contact.php" class="text-sm font-medium <?= ($activeNav ?? '') === 'contact' ? 'text-pbk-primary' : '' ?>">Kontak</a>
      <a href="<?= BASE_URL ?>/contact.php#pmb" class="mt-2 inline-flex justify-center bg-pbk-primary text-white text-sm font-semibold px-5 py-2.5 rounded-full">Daftar Sekarang</a>
    </div>
  </div>
</header>

<main id="main">
