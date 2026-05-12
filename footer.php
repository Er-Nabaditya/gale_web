<!-- ── FOOTER ── -->



<!-- Main Footer -->
<footer class="gale-footer">
  <div class="container">
    <div class="footer-grid">

      <!-- Col 1 — Logo + About -->
      <div class="footer-col footer-about">
        <div class="footer-logo">
          <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
          <?php else : ?>
            <span class="footer-logo-text">🌿 GALE</span>
          <?php endif; ?>
        </div>
        <p>Supporting tribal communities in Palghar through sustainable initiatives, skill development, and ethical practices.</p>
      </div>

      <!-- Col 2 — Quick Links -->
      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/')); ?>">About Us</a></li>
          <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">Our Products</a></li>
          <li><a href="<?php echo esc_url(home_url('/impact')); ?>">Our Impact</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
        </ul>
      </div>

      <!-- Col 3 — Contact -->
      <div class="footer-col">
        <h4>Contact</h4>
        <ul class="footer-contact-list">
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            Gale Village, Palghar, Maharashtra
          </li>
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.21 1.18 2 2 0 012.22 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.56-.56a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
            </svg>
            +91 98765 43210
          </li>
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
              <polyline points="22,6 12,13 2,6" />
            </svg>
            info@galelivelihood.org
          </li>
        </ul>
      </div>

    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <p>© <?php echo date('Y'); ?> Gale Livelihood Centre. Supported by Rotary Club of Bombay. All Rights Reserved.</p>
      <p class="footer-tagline">Every Purchase Creates Impact</p>
    </div>
  </div>
</footer>
<!-- ── END FOOTER ── -->

<?php wp_footer(); ?>
</body>

</html>