/* ===================================================================
   Politeknik Bhakti Kartini — main.js
   Navbar mobile, scroll reveal, counter animasi, lightbox galeri,
   filter galeri, validasi form kontak, back-to-top.
   =================================================================== */

document.addEventListener("DOMContentLoaded", () => {
  /* ---------------- Navbar mobile toggle ---------------- */
  const menuBtn = document.getElementById("menuToggle");
  const mobileMenu = document.getElementById("mobileMenu");
  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener("click", () => {
      const isOpen = mobileMenu.classList.toggle("open");
      menuBtn.setAttribute("aria-expanded", isOpen ? "true" : "false");
      const iconOpen = menuBtn.querySelector(".icon-open");
      const iconClose = menuBtn.querySelector(".icon-close");
      if (iconOpen && iconClose) {
        iconOpen.classList.toggle("hidden", isOpen);
        iconClose.classList.toggle("hidden", !isOpen);
      }
    });
  }

  /* ---------------- Navbar shadow on scroll ---------------- */
  const nav = document.getElementById("siteNav");
  const onScrollNav = () => {
    if (!nav) return;
    if (window.scrollY > 8) {
      nav.classList.add("navbar-shadow", "bg-[#f8f7f2]/95", "backdrop-blur");
    } else {
      nav.classList.remove("navbar-shadow");
    }
  };
  onScrollNav();
  window.addEventListener("scroll", onScrollNav, { passive: true });

  /* ---------------- Scroll reveal ---------------- */
  const revealEls = document.querySelectorAll(".reveal");
  if ("IntersectionObserver" in window && revealEls.length) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );
    revealEls.forEach((el) => io.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add("is-visible"));
  }

  /* ---------------- Counter animasi (count-up) ---------------- */
  const counters = document.querySelectorAll(".count-up");
  if ("IntersectionObserver" in window && counters.length) {
    const countIO = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          const el = entry.target;
          const target = parseInt(el.dataset.target || "0", 10);
          const suffix = el.dataset.suffix || "";
          const duration = 1400;
          const start = performance.now();
          const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target).toLocaleString("id-ID") + suffix;
            if (progress < 1) requestAnimationFrame(step);
          };
          requestAnimationFrame(step);
          countIO.unobserve(el);
        });
      },
      { threshold: 0.4 }
    );
    counters.forEach((el) => countIO.observe(el));
  }

  /* ---------------- Back to top ---------------- */
  const backToTop = document.getElementById("backToTop");
  if (backToTop) {
    window.addEventListener(
      "scroll",
      () => {
        backToTop.classList.toggle("show", window.scrollY > 500);
      },
      { passive: true }
    );
    backToTop.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  /* ---------------- Galeri: filter kategori ---------------- */
  const filterBtns = document.querySelectorAll(".filter-btn");
  const galleryItems = document.querySelectorAll(".gallery-item");
  if (filterBtns.length && galleryItems.length) {
    filterBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        filterBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        const cat = btn.dataset.filter;
        galleryItems.forEach((item) => {
          const show = cat === "all" || item.dataset.category === cat;
          item.style.display = show ? "" : "none";
        });
      });
    });
  }

  /* ---------------- Galeri: lightbox ---------------- */
  const lightbox = document.getElementById("lightbox");
  const lightboxImg = document.getElementById("lightboxImg");
  const lightboxCaption = document.getElementById("lightboxCaption");
  const lightboxClose = document.getElementById("lightboxClose");

  if (lightbox && lightboxImg) {
    galleryItems.forEach((item) => {
      item.addEventListener("click", () => {
        const img = item.querySelector("img");
        lightboxImg.src = img.src;
        lightboxImg.alt = img.alt;
        if (lightboxCaption) lightboxCaption.textContent = img.alt;
        lightbox.classList.add("open");
        document.body.style.overflow = "hidden";
      });
    });
    const closeLightbox = () => {
      lightbox.classList.remove("open");
      document.body.style.overflow = "";
    };
    lightboxClose?.addEventListener("click", closeLightbox);
    lightbox.addEventListener("click", (e) => {
      if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeLightbox();
    });
  }

  /* ---------------- Form kontak: validasi sederhana ---------------- */
  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    const successBox = document.getElementById("formSuccess");

    const showError = (input, message) => {
      input.classList.add("field-error");
      const msgEl = document.getElementById(input.id + "Error");
      if (msgEl) {
        msgEl.textContent = message;
        msgEl.classList.add("show");
      }
    };
    const clearError = (input) => {
      input.classList.remove("field-error");
      const msgEl = document.getElementById(input.id + "Error");
      if (msgEl) msgEl.classList.remove("show");
    };

    contactForm.querySelectorAll("input, textarea, select").forEach((input) => {
      input.addEventListener("input", () => clearError(input));
    });

    contactForm.addEventListener("submit", (e) => {
      e.preventDefault();
      let valid = true;

      const name = document.getElementById("name");
      const email = document.getElementById("email");
      const subject = document.getElementById("subject");
      const message = document.getElementById("message");

      if (!name.value.trim()) {
        showError(name, "Nama wajib diisi.");
        valid = false;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!email.value.trim()) {
        showError(email, "Email wajib diisi.");
        valid = false;
      } else if (!emailPattern.test(email.value.trim())) {
        showError(email, "Format email tidak valid.");
        valid = false;
      }

      if (subject && !subject.value) {
        showError(subject, "Silakan pilih topik.");
        valid = false;
      }

      if (!message.value.trim() || message.value.trim().length < 10) {
        showError(message, "Pesan minimal 10 karakter.");
        valid = false;
      }

      if (!valid) return;

      // Simulasi pengiriman (belum terhubung ke backend/API)
      const submitBtn = contactForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.disabled = true;
      submitBtn.textContent = "Mengirim...";

      setTimeout(() => {
        contactForm.reset();
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        if (successBox) {
          successBox.classList.remove("hidden");
          successBox.scrollIntoView({ behavior: "smooth", block: "center" });
          setTimeout(() => successBox.classList.add("hidden"), 5000);
        }
      }, 900);
    });
  }

  /* ---------------- Tahun footer otomatis ---------------- */
  document.querySelectorAll(".current-year").forEach((el) => {
    el.textContent = new Date().getFullYear();
  });
});
