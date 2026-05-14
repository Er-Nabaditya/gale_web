/* ══════════════════════════════════
   GALE LIVELIHOOD — MAIN JS
   File: js/gale-custom.js
══════════════════════════════════ */

(function ($) {
  "use strict";

  $(document).ready(function () {
    // ══ 1. MOBILE HAMBURGER MENU ════════════
    const hamburger = document.getElementById("galeHamburger");
    const navLinks = document.getElementById("galeNavLinks");

    if (hamburger && navLinks) {
      hamburger.addEventListener("click", function () {
        navLinks.classList.toggle("open");
        hamburger.classList.toggle("active");
      });

      // Close menu on outside click
      document.addEventListener("click", function (e) {
        if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
          navLinks.classList.remove("open");
          hamburger.classList.remove("active");
        }
      });
    }

    // ══ 2. STICKY HEADER SHADOW ════════════
    const header = document.getElementById("gale-header");
    if (header) {
      window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
          header.style.boxShadow = "0 2px 20px rgba(0,0,0,0.1)";
        } else {
          header.style.boxShadow = "none";
        }
      });
    }

    // ═══════════════════════════════════════
    // PRODUCTS SLIDER (SLIDE + DOTS WORKING)
    // ═══════════════════════════════════════
    document.addEventListener("DOMContentLoaded", function () {
      const slider = document.getElementById("productsSlider");
      const viewport = document.querySelector(".products-slider-viewport");
      const prevBtn = document.getElementById("sliderPrev");
      const nextBtn = document.getElementById("sliderNext");
      const dotsWrap = document.getElementById("sliderDots");

      if (!slider || !viewport || !dotsWrap) return;

      let currentPage = 0;
      const GAP = 20; // CSS gap ke same

      // Visible cards per screen
      function getVisibleSlides() {
        if (window.innerWidth <= 767) return 1;
        if (window.innerWidth <= 991) return 2;
        return 3;
      }

      // All slides
      function getSlides() {
        return slider.querySelectorAll(".product-slide");
      }

      // Total pages
      function getTotalPages() {
        const totalSlides = getSlides().length;
        const visibleSlides = getVisibleSlides();

        if (totalSlides <= visibleSlides) {
          return 1;
        }

        return Math.ceil(totalSlides / visibleSlides);
      }

      // Build dots
      function buildDots() {
        dotsWrap.innerHTML = "";

        const totalPages = getTotalPages();

        // Hamesha dots banao (even if 1 page)
        for (let i = 0; i < totalPages; i++) {
          const dot = document.createElement("button");
          dot.type = "button";
          dot.className = "slider-dot";

          if (i === currentPage) {
            dot.classList.add("active");
          }

          dot.addEventListener("click", function () {
            goToPage(i);
          });

          dotsWrap.appendChild(dot);
        }
      }

      // Update active dot
      function updateDots() {
        const dots = dotsWrap.querySelectorAll(".slider-dot");

        dots.forEach((dot, index) => {
          dot.classList.toggle("active", index === currentPage);
        });
      }

      // Update arrows
      function updateArrows() {
        const totalPages = getTotalPages();

        if (prevBtn) {
          prevBtn.disabled = currentPage === 0;
        }

        if (nextBtn) {
          nextBtn.disabled = currentPage === totalPages - 1;
        }
      }

      // Slide function
      function goToPage(pageIndex) {
        const slides = getSlides();

        if (!slides.length) return;

        const visibleSlides = getVisibleSlides();
        const totalPages = getTotalPages();

        // Safe page index
        currentPage = Math.max(0, Math.min(pageIndex, totalPages - 1));

        // Single card width
        const slideWidth = slides[0].getBoundingClientRect().width;

        // One full page width
        const pageWidth = (slideWidth + GAP) * visibleSlides;

        // Move slider
        const translateX = currentPage * pageWidth;

        slider.style.transform = `translate3d(-${translateX}px, 0, 0)`;

        updateDots();
        updateArrows();
      }

      // Prev button
      if (prevBtn) {
        prevBtn.addEventListener("click", function () {
          goToPage(currentPage - 1);
        });
      }

      // Next button
      if (nextBtn) {
        nextBtn.addEventListener("click", function () {
          goToPage(currentPage + 1);
        });
      }

      // Touch swipe
      let startX = 0;

      viewport.addEventListener("touchstart", function (e) {
        startX = e.touches[0].clientX;
      });

      viewport.addEventListener("touchend", function (e) {
        const endX = e.changedTouches[0].clientX;
        const diff = startX - endX;

        if (Math.abs(diff) < 50) return;

        if (diff > 0) {
          goToPage(currentPage + 1);
        } else {
          goToPage(currentPage - 1);
        }
      });

      // Rebuild on resize
      window.addEventListener("resize", function () {
        currentPage = 0;
        buildDots();

        setTimeout(function () {
          goToPage(0);
        }, 100);
      });

      // Initial load
      setTimeout(function () {
        buildDots();
        goToPage(0);
      }, 150);
    });
    // ══ 4. SMOOTH SCROLL FOR ANCHOR LINKS ══
    $('a[href*="#"]')
      .not('[href="#"]')
      .on("click", function (e) {
        const target = $(this.hash);
        if (target.length) {
          e.preventDefault();
          $("html, body").animate(
            {
              scrollTop: target.offset().top - 80,
            },
            600,
          );
        }
      });

    // ══ 5. ACTIVE NAV LINK ══════════════════
    const currentUrl = window.location.href;
    $(".gale-nav-links a").each(function () {
      if (this.href === currentUrl) {
        $(this).addClass("active");
      }
    });

    // ══ 6. SCROLL REVEAL ANIMATION ══════════
    const observerOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("revealed");
        }
      });
    }, observerOptions);

    document
      .querySelectorAll(
        ".mission-card, .product-slide, .testimonial-card, .why-item, .farm-step",
      )
      .forEach(function (el) {
        el.classList.add("reveal-on-scroll");
        observer.observe(el);
      });
  });
})(jQuery);
