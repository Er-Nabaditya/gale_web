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

    // ══ 3. PRODUCTS SLIDER ══════════════════
    // ══ PRODUCTS SLIDER ══
    const slider = document.getElementById("productsSlider");
    const prevBtn = document.getElementById("sliderPrev");
    const nextBtn = document.getElementById("sliderNext");
    const dotsWrap = document.getElementById("sliderDots");

    if (slider && prevBtn && nextBtn) {
      let currentIndex = 0;

      function getSlidesVisible() {
        if (window.innerWidth <= 600) return 1;
        if (window.innerWidth <= 992) return 2;
        return 3;
      }

      function getSlides() {
        return slider.querySelectorAll(".product-slide");
      }

      function getSlideWidth() {
        const slides = getSlides();
        if (!slides.length) return 0;
        const style = window.getComputedStyle(slider);
        const gap = parseFloat(style.gap) || 24;
        return slides[0].offsetWidth + gap;
      }

      function buildDots() {
        if (!dotsWrap) return;
        dotsWrap.innerHTML = "";
        const total = getSlides().length;
        const visible = getSlidesVisible();
        const numDots = Math.ceil(total / visible);
        for (let i = 0; i < numDots; i++) {
          const dot = document.createElement("button");
          dot.classList.add("slider-dot");
          if (i === 0) dot.classList.add("active");
          dot.addEventListener("click", () => goToSlide(i * visible));
          dotsWrap.appendChild(dot);
        }
      }

      function updateDots() {
        if (!dotsWrap) return;
        const visible = getSlidesVisible();
        const activeDot = Math.floor(currentIndex / visible);
        dotsWrap.querySelectorAll(".slider-dot").forEach((d, i) => {
          d.classList.toggle("active", i === activeDot);
        });
      }

      function goToSlide(index) {
        const slides = getSlides();
        const visible = getSlidesVisible();
        const max = Math.max(0, slides.length - visible);
        currentIndex = Math.min(Math.max(index, 0), max);
        const offset = currentIndex * getSlideWidth();
        slider.style.transform = `translateX(-${offset}px)`;
        slider.style.transition = "transform 0.4s ease";
        updateDots();
      }

      prevBtn.addEventListener("click", () =>
        goToSlide(currentIndex - getSlidesVisible()),
      );
      nextBtn.addEventListener("click", () =>
        goToSlide(currentIndex + getSlidesVisible()),
      );

      // Touch swipe
      let touchStartX = 0;
      slider.addEventListener(
        "touchstart",
        (e) => (touchStartX = e.touches[0].clientX),
      );
      slider.addEventListener("touchend", (e) => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
          if (diff > 0) goToSlide(currentIndex + getSlidesVisible());
          else goToSlide(currentIndex - getSlidesVisible());
        }
      });

      window.addEventListener("resize", () => {
        buildDots();
        goToSlide(0);
      });

      buildDots();
    }

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
