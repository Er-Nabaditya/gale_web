<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <!-- ── HEADER / NAVBAR ── -->
  <header class="gale-header" id="gale-header">
    <div class="container">
      <nav class="gale-nav">

        <!-- Logo -->
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="gale-logo">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/logo_gale.png"
            alt="Gale Livelihood"
            class="gale-logo-img">
        </a>

        <!-- Nav Links -->
        <ul class="gale-nav-links" id="galeNavLinks">
          <li><a href="<?php echo esc_url(home_url('/')); ?>">About</a></li>
          <li><a href="<?php echo esc_url(home_url('/impact')); ?>">Impact</a></li>
          <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">Products</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
        </ul>

        <!-- Right Icons -->
        <div class="gale-nav-right">
          <!-- Cart Icon -->
          <?php if (function_exists('WC')) : ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="gale-cart-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <path d="M16 10a4 4 0 01-8 0" />
              </svg>
              <?php $count = WC()->cart->get_cart_contents_count(); ?>
              <?php if ($count > 0) : ?>
                <span class="cart-count"><?php echo esc_html($count); ?></span>
              <?php endif; ?>
            </a>
          <?php endif; ?>

          <!-- User Icon -->
          <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="gale-user-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
              <circle cx="12" cy="7" r="4" />
            </svg>
          </a>

          <!-- Sign Up Button -->
          <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="gale-btn-signup">
            Sign Up
          </a>

          <!-- Mobile Hamburger -->
          <button class="gale-hamburger" id="galeHamburger" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>

      </nav>
    </div>
  </header>
  <!-- ── END HEADER ── -->