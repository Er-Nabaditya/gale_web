<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <?php wp_body_open(); ?>

  <header class="gale-header">

    <div class="container">

      <div class="header-wrapper">

        <!-- Logo -->
        <div class="header-logo">
          <a href="<?php echo home_url(); ?>">

            <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/logo.png.png" alt="Logo">

          </a>
        </div>

        <!-- Navigation -->
        <nav class="header-nav">

          <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'menu-list',
          ));
          ?>

        </nav>

        <!-- Right Side -->
        <div class="header-right">

          <!-- Cart -->
          <a href="<?php echo wc_get_cart_url(); ?>" class="header-icon">
            🛒
          </a>

          <!-- Account -->
          <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="header-icon">
            👤
          </a>

          <!-- Button -->
          <a href="#" class="signup-btn">
            Sign Up
          </a>

        </div>

      </div>

    </div>

  </header>